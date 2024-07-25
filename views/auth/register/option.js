const modal = new bootstrap.Modal(document.getElementById('modal_register'));


window.addEventListener('DOMContentLoaded',  (e) => {
    modal.show();

    const register = {
        form: document.getElementById('form_register'),
    };
    function clearErrors(){
        document.getElementById('username_reg_error').textContent = '';
        document.getElementById('reg_firstname_error').textContent = '';
        document.getElementById('reg_secondname_error').textContent = '';
        document.getElementById('reg_age_error').textContent = '';
        document.getElementById('reg_password_error').textContent = '';
        document.getElementById('reg_repassword_error').textContent = '';
    }

    function errorLog(code){
        switch (code) {
            case 1:
            case 2:
                return 'username_reg_error';
            case 3:
                return 'reg_firstname_error';
            case 4:
                return 'reg_secondname_error';
            case 5:
            case 6:
            case 7:
                return 'reg_age_error';
            case 8:
                return 'reg_password_error';
            case 9:
                return 'reg_repassword_error';
            case 10:
                return 'reg_repassword_error';
        }
    }


    register.form.onsubmit = async (e) => {
        e.preventDefault();
        const formElements = new FormData(register.form);

        const response = await data(formElements).then(response => response.json());

        clearErrors();

        if(response.errors?.length >= 1){
            for (const error of response.errors) {
                const errorClass = errorLog(error.code);
                document.getElementById(errorClass).textContent = error.message;
            }
        }
        else{
            if(response.status){
                window.location.href = response.redirect;
            }
        }
    }

    async function data(data){
        const url = 'http://localhost:63342/filmsTask/views/auth/register/validate.php';
        return await fetch(url, {
            method: 'POST',
            body: JSON.stringify(Object.fromEntries(data)),
            headers: {
                'Content-Type': 'application/json'
            }
        });
    }
});
window.onclick = function(e) {
    modal.show();
}

