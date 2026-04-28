/**
 * Configuration de base pour les requêtes AJAX.
 * Axios n'est pas requis pour ce projet Blade.
 */
window.csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
