<?php

namespace App\Service;

use Psr\Cache\CacheItemPoolInterface;

class RedisDataManager
{
    private const TTL = 86400; // 24 heures

    public function __construct(private CacheItemPoolInterface $cachePool) {}

    // 1. ÉCRIRE
    // Ajout du paramètre $creatorIp (optionnel par sécurité)
   public function writeData(string $key, string $content, ?string $creatorIp, bool $isModifiable): void
   {
        $cacheItem = $this->cachePool->getItem($key);
        
        // Le service structure lui-même les données
        $payload = [
            'content'     => $content,
            'creator_ip'  => $creatorIp,
            'is_editable' => $isModifiable
        ];

        $cacheItem->set($payload);
        $cacheItem->expiresAfter(self::TTL);
            
        $this->cachePool->save($cacheItem);
    }
    // 2. LIRE
    public function readData(string $key): ?array
    {
        $cacheItem = $this->cachePool->getItem($key);
        
        if (!$cacheItem->isHit()) {
            return null; 
        }
      
        // Retourne le tableau complet : ['item' => [...], 'is_editable' => true/false, 'creator_ip' => '...']
        return $cacheItem->get();
    }

   public function lockDocument(string $key): void
  {
    // 1. On récupère les données actuelles (pour ne pas perdre le texte déjà sauvegardé)
    $currentData = $this->readData($key);

    if ($currentData) {
        // 2. On passe l'état à false dans les données
        $currentData['is_editable'] = false;
        
        // 3. On réécrit dans Redis avec le flag à false pour verrouiller
        // (Ici on utilise votre logique habituelle de write/set mais configurée pour verrouiller)
        $this->writeData($key, $currentData, false);
    }
}
}