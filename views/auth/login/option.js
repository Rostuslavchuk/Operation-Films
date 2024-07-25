const modal_login = new bootstrap.Modal(document.getElementById('modal_login'));

window.addEventListener('DOMContentLoaded',  (e) => {
    e.preventDefault();

    modal_login.show();


    const login = {
        form: document.getElementById('form_login'),
    }

    function errorLog(code){
        switch (code) {
            case 1:
                return 'username_login_error';
            case 2:
                return 'password_login_error';
            case 3:
                return 'username_login_error';
            case 4:
                return 'password_login_error';
        }
    }

    function clearErrors(){
        document.getElementById('username_login_error').textContent = '';
        document.getElementById('password_login_error').textContent = '';
    }

    login.form.onsubmit = async (e) => {
        e.preventDefault();

        const formData = new FormData(login.form);
        const response = await data(formData).then(response => response.json());
        clearErrors();

        if(response.errors?.length >= 1){
            for (const error of response.errors) {
                const className = errorLog(error.code);
                document.getElementById(className).textContent = error.message;
            }
        }
        else{
            if(response.status){
                if(response.redirect){
                    window.location.href = response.redirect;
                }
                else{
                    console.log(response.status);
                }
            }
        }
    };

    async function data(data){
        const url = 'http://localhost:63342/filmsTask/views/auth/login/validate.php';

        return await fetch(url, {
           method: 'POST',
           body: JSON.stringify(Object.fromEntries(data)),
           headers: {
               "Content-Type": "application/json"
           }
        });
    }
})



window.onclick = (e) => {
    modal_login.show();
}