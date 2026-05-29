<?php

namespace App\Service;

use Psr\Cache\CacheItemPoolInterface;

class RedisDataManager
{
    private const TTL = 86400; // 24 heures
    private const DAILY_LIMIT = 5000;

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

public function checkAndIncrementDailyRoomLimit(int $limit = 5000): bool
{
    $key = 'rooms_daily_' . date('Y-m-d');
    $cacheItem = $this->cachePool->getItem($key);

    $count = $cacheItem->isHit() ? (int) $cacheItem->get() : 0;

    // LOG TEMPORAIRE
   // error_log(">>> ROOM LIMIT CHECK — clé: $key | count: $count | limit: $limit");

    if ($count >= $limit) {
        return false;
    }

    $cacheItem->set($count + 1);
    $cacheItem->expiresAfter(86400);
    $this->cachePool->save($cacheItem);

    return true;
}


}