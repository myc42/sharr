

    // Récupération du token depuis Twig
    const token = "{{ token }}";

    const input = document.getElementById('txtInput');

    // Fonction debounce pour limiter les requêtes
    function debounce(func, wait) {
        let timeout;
        return function(...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), wait);
        };
    }

    // Fonction pour envoyer la valeur au serveur
    function sendValueToServer(value) {
        fetch(`/${token}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ champ: value })
        })
        .then(res => res.json())
        .then(data => {
            // Optionnel : juste log dans la console, aucune erreur affichée à l'utilisateur
            console.log('Mise à jour envoyée');
        })
        .catch(err => {
            console.error('Erreur côté JS (log seulement)', err);
        });
    }

    // Déclenchement de la fonction avec debounce
    const debouncedSend = debounce(() => sendValueToServer(input.value), 400);

    input.addEventListener('input', debouncedSend);


