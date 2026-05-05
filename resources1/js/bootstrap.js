import axios from "axios";
window.axios = axios;

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

// If you are using Alpine.js, uncomment the lines below:
import Alpine from "alpinejs";
window.Alpine = Alpine;
Alpine.start();
