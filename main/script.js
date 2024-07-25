document.addEventListener('DOMContentLoaded', function(e){
    e.preventDefault();

    const modalAdd = new bootstrap.Modal(document.getElementById('modal_add'));
    const modalConfirmDelete = new bootstrap.Modal(document.getElementById('modal_confirm'));


    const addActions = {
        buttonAdd: document.getElementById('add_film'),
        form: document.getElementById('add_form'),
        closeTop: document.getElementById('close_top'),
        closeFooter: document.getElementById('close_footer'),
    };
    const confirmDelete = {
        form: document.getElementById('confirm-form'),
        closeFooter: document.getElementById('close_confirm_footer'),
        formTitle: document.getElementById('form_film_title'),
        idFilm: 0
    }

    const buttonsAction = {
        deleteButtons: document.querySelectorAll('.delete'),
        viewButtons: document.querySelectorAll('.view')
    }
    const lastActions = {
        logout: document.getElementById('logout'),
        upload_file: document.getElementById('upload_file'),
        sortByTitle: document.getElementById('sort_by_title'),
    }
    const search = {
        searchInput: document.getElementById('search_film'),
        dropdownSearch: document.getElementById('dropdown-search')
    }




    // add film
    closeModal(addActions.closeTop);
    closeModal(addActions.closeFooter);

    function closeModal(btn){
        btn.onclick = e => {
            e.preventDefault();
            addActions.form.reset();
        }
    }
    function clearModalErrors(){
        document.getElementById('title_error').textContent = '';
        document.getElementById('release_error').textContent = '';
        document.getElementById('format_error').textContent = '';
        document.getElementById('actors_error').textContent = '';
    }
    function errorCode(code){
        switch (code){
            case 1:
                return 'title_error';
            case 2:
            case 3:
                return 'release_error';
            case 4:
                return 'format_error';
            case 5:
            case 6:
                return 'actors_error';
        }
    }
    addActions.buttonAdd.onclick = (e) => {
        e.preventDefault();
        modalAdd.show();
    };
    addActions.form.onsubmit = async (e) => {
        e.preventDefault();

        const formData = new FormData(addActions.form);
        formData.set('action', 'add');

        const response = await data(JSON.stringify(Object.fromEntries(formData))).then(response => response.json());
        clearModalErrors();


        if(response.errors?.length >= 1){
            for (const error of response.errors) {
                const className = errorCode(error.code);
                document.getElementById(className).textContent = error.message;
            }
        }
        else{
            if(response.film){
                addFilm(response.film);
                deleteButtonConvert(response.film.id);
                viewButtonConvert(response.film.id);
            }
            addActions.closeFooter.click();
            e.target.reset();
        }
    }
    //add film (html)
    function addFilm(film){
        let filmAdd = `
            <tr data-id="${film.id}">
                <td class="title">${film.title}</td>
                <td class="release">${film.release_year}</td>
                <td class="format">${film.format}</td>
                <td class="actors">${film.actors}</td>
                <td>
                    <div class="d-flex flex-row">
                        <button class="border rounded-start delete" data-delete-id="${film.id}">
                            <i class='fa fa-trash'></i>
                        </button>
                        <button class="border border-start-0 rounded-end view" data-view-id="${film.id}">
                            <i class="fa fa-eye"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `;
        document.getElementById('table_body').insertAdjacentHTML('beforeend', filmAdd);
    }
    //


    // delete
    buttonsAction.deleteButtons.forEach(deleteButtons => {
        deleteFilm(deleteButtons);
    });
    function deleteButtonConvert(id) {
        const buttonDelete = document.querySelector(`#table_body tr[data-id="${id}"] td button[data-delete-id="${id}"]`);
        deleteFilm(buttonDelete);
    }
    function deleteFilm(btnDelete){
        btnDelete.onclick = (e) => {
            e.preventDefault();

            if (btnDelete) {
                const btnId = parseInt(btnDelete.getAttribute('data-delete-id'));
                const film = document.querySelector(`#table_body tr[data-id="${btnId}"]`);

                if (film) {
                    confirmDelete.formTitle.textContent = film.querySelector('.title').textContent;
                    confirmDelete.idFilm = btnId;
                    modalConfirmDelete.show();
                }
            }
        }
    }
    confirmDelete.form.onsubmit = async (e) => {
        e.preventDefault();

        if(confirmDelete.idFilm){
            const response = await data(JSON.stringify({id: confirmDelete.idFilm, action: 'delete', username: confirmDelete.form.elements['username'].value}))
                .then(response => response.json());

            if(response.deleted) {
                document.querySelector(`#table_body tr[data-id="${confirmDelete.idFilm}"]`).remove();
                confirmDelete.closeFooter.click();
            }
        }
    };
    //


    //view
    buttonsAction.viewButtons.forEach(viewButton => {
        buttonView(viewButton);
    });

    function viewButtonConvert(id){
        const btnView = document.querySelector(`#table_body tr[data-id="${id}"] td button[data-view-id="${id}"]`);
        buttonView(btnView);
    }

    function buttonView(viewButton){
        if(viewButton){
            viewButton.onclick = (e) => {
                e.preventDefault();
                const viewId = parseInt(viewButton.getAttribute('data-view-id'));
                const filmTr = document.querySelector(`#table_body tr[data-id="${viewId}"]`);

                if(filmTr){
                    const data = {
                        title: filmTr.querySelector('.title').textContent,
                        release: filmTr.querySelector('.release').textContent,
                        format: filmTr.querySelector('.format').textContent,
                        actors: filmTr.querySelector('.actors').textContent
                    }
                    window.location.href = `view.php`;
                }
            }
        }
    }
    //


    //logout
    lastActions.logout.onclick = e => {
        e.preventDefault();
        window.location.href = '../../views/auth/login/logout.php';
    }

    //upload_file
    lastActions.upload_file.onclick = e => {
        e.preventDefault();
        window.location.href = '../../views/upload_films/upload.php';
    }


    // sort
    lastActions.sortByTitle.onclick = (e) => {
        e.preventDefault();

        const tableBody = document.getElementById('table_body');
        const rows = Array.from(tableBody.querySelectorAll('tr'));

        rows.sort((a, b) => {
            const rowA = a.querySelector('.title').textContent;
            const rowB = b.querySelector('.title').textContent;

            return rowA.localeCompare(rowB);
        });

        tableBody.innerHTML = '';

        rows.forEach(row => {
            tableBody.appendChild(row);
        })
    }


    // search
    let searchType;
    search.dropdownSearch.addEventListener('change', (e) => {
        searchType = null;
        searchType = e.target.value;
    });



    search.searchInput.oninput = (e) => {
        e.preventDefault();

        const bodyList = document.getElementById('table_body');
        const rows = Array.from(bodyList.querySelectorAll('tr'));

        let input = e.target.value;
        rows.forEach(row => {
            let type;
            if(!searchType){
                return
            }
            if(searchType === 'character'){
                type = row.querySelector('.actors');
            }
            if(searchType === 'film'){
                type = row.querySelector('.title');
            }

            if(type.textContent.match(input)){
                row.classList.remove('none');
            }
            else{
                row.classList.add('none');
            }
        });
    }




    // request(POST)
    async function data(data){
        const url = 'http://localhost:63342/filmsTask/main/validate.php';
        if(data){
            return await fetch(url, {
                method: 'POST',
                body: data,
                headers: {
                    'Content-Type': 'application/json'
                }
            })
        }
    }
});