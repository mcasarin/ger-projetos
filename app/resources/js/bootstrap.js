import axios from 'axios';
window.axios = axios;

// Importando SweetAlert2 para notificações
import Swal from 'sweetalert2';
window.Swal = Swal;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
