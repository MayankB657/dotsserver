// Inject PHP data into JavaScript
const rootVariables = @json($rootVariables);

// Update CSS variables dynamically
const root = document.documentElement;
Object.keys(rootVariables).forEach(key => {
    root.style.setProperty(key, rootVariables[key]);
});