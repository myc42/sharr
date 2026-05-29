document.addEventListener('DOMContentLoaded', () => {
    // 1. Ciblage des éléments du DOM
    const textarea = document.getElementById('input');
    const statusText = document.getElementById('stSave');

    if (!textarea || !statusText) return; // Sécurité si les éléments n'existent pas

    // 2. Récupération des paramètres injectés par Symfony (Twig)
    const dataset = document.body.dataset;
    const csrfToken = dataset.csrfToken;
    const saveUrl = dataset.saveUrl;
  

    // 3. Variables d'état
    let timeoutId = null;
    // On initialise le dernier contenu sauvegardé avec le contenu actuel au chargement
    let lastSavedContent = textarea.value; 

    // 4. Écouteur d'événement
    textarea.addEventListener('input', () => {
        statusText.textContent = 'Modifications en attente...';
        
        // On annule le timer précédent (Debounce)
        clearTimeout(timeoutId);

        // On lance un nouveau timer de 3 secondes
        timeoutId = setTimeout(() => {
            const currentContent = textarea.value;

            // --- VÉRIFICATION CRUCIALE ---
            // On compare avec la dernière version envoyée.
            // Si l'utilisateur a tapé, puis effacé pour revenir au texte initial,
            // ou s'il n'y a pas de vraie modification, on annule l'envoi au serveur.
            if (currentContent === lastSavedContent) {
                statusText.textContent = 'Sauvegarde auto';
                return; 
            }

            statusText.textContent = 'Enregistrement...';

            // Envoi de la requête AJAX
            fetch(saveUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ content: currentContent })
            })
            .then(response => {
                if (!response.ok) throw new Error("Erreur réseau");
                return response.json();
            })
            .then(data => {
                if (data.status === 'success') {
                    // Mise à jour de la mémoire locale : 
                    // la nouvelle référence devient le texte qu'on vient d'envoyer
                    lastSavedContent = currentContent;
                    
                    statusText.textContent = 'Sauvegardé !';
                    
                    setTimeout(() => {
                        statusText.textContent = 'Sauvegarde auto';
                    }, 100);
                }
            })
            .catch(error => {
                console.error('Erreur lors de la sauvegarde :', error);
                statusText.textContent = 'Erreur de sauvegarde';
            });

        }, 1000); // 3000 millisecondes = 3 secondes
    });
});