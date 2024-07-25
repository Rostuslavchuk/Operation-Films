const modal = new bootstrap.Modal(document.getElementById('modal_upload'));



window.addEventListener('DOMContentLoaded',  async (e) => {
    e.preventDefault();
    modal.show();



    const upload = {
        form: document.getElementById('form_upload')
    }

    function errorLog(code){
        switch (code){
            case 1:
            case 2:
                return 'username_upload_error';
            case 3:
            case 4:
            case 5:
            case 6:
                return 'file_upload_error';
        }
    }

    function errorClear(){
        document.getElementById('username_upload_error').textContent = '';
        document.getElementById('file_upload_error').textContent = '';
    }



    upload.form.onsubmit = async (e) => {
            e.preventDefault();

            const username = upload.form.elements['username_upload'].value;
            const file = upload.form.elements['upload_file'].files[0];

            let fileContent = '';

            if(file){
                const reader = new FileReader();
                reader.onload = async (e) => {
                    fileContent = e.target.result;
                    await sendDataToServer(username, file.name, file.size, fileContent);
                }
                reader.readAsText(file);
            }
            else{
                await sendDataToServer(username, '', '', '');
            }
        }

        async function sendDataToServer(username, filename, filesize, fileContent) {
            const formData = new FormData();
            formData.append('username', username);
            formData.append('filename', filename);
            formData.append('filesize', filesize);
            formData.append('fileContent', fileContent);

            const response = await data(formData).then(response => response.json());
            errorClear();

            if(response){
                if(response.errors?.length >= 1){
                    for (const error of response.errors) {
                        const className = errorLog(error.code);
                        document.getElementById(className).textContent = error.message;
                    }
                }
                else{
                    if(response.status){
                        window.location.href = response.redirect;
                    }
                }
            }
        }


        async function data(data){
            const url = 'http://localhost:63342/filmsTask/views/upload_films/validate.php';
            return await fetch(url,{
                method: 'POST',
                body: JSON.stringify(Object.fromEntries(data)),
                headers:{
                    'Content-Type': 'application/json'
                }
            });
        }
});


window.onclick = (e) => {
    modal.show();
}

