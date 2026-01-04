import './stimulus_bootstrap.js';
import './styles/app.css';

// Minimal JS helpers for the library page
async function fetchJson(url){
	const r = await fetch(url, {credentials:'same-origin'});
	if(!r.ok) throw new Error('Fetch error');
	return r.json();
}

window.App = {
	fetchJson,
	// small helper to safely set text
	setText(id, text){
		const el = document.getElementById(id);
		if(el) el.textContent = text;
	}
};

console.log('assets/app.js loaded');
