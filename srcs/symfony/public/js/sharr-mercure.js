const body = document.body;
const hubUrl  = body.dataset.mercureHub;
const baseUrl = body.dataset.mercureTopic;

const token = window.location.pathname.replace('/', '');
const url = new URL(hubUrl);
url.searchParams.append("topic", baseUrl + "/" + token);

const es = new EventSource(url.toString());

es.onopen = () => console.log("✅ Connecté à Mercure !");

es.onmessage = (e) => {
    const data = JSON.parse(e.data);
    const newContent = data.content;
    document.getElementById('input').value = newContent;
    init();
};

es.onerror = (e) => console.error("❌ Erreur:", e, "État:", es.readyState);