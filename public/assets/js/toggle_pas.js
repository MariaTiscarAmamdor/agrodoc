// document.addEventListener('DOMContentLoaded', (event) => {
//     const togglePassword = document.querySelector('#togglePassword');
//     const password = document.getElementById('pas');
//     const icon = togglePassword.querySelector('i');

//     togglePassword.addEventListener('click', function (e) {       
//         const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
//         password.setAttribute('type', type);       
//         icon.classList.toggle('fa-eye'); icon.classList.toggle('fa-eye-slash');
//     });
// });

    document.getElementById('togglePassword').addEventListener('click', function() {
        let passwordInput = document.getElementById('pas');
        let icon = this.querySelector('i');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    });
