const checkboxes = document.querySelectorAll(".checkboxes")
const tabla = document.querySelector('#cuerpo');
let opciones = {
    method: 'POST'
}
let formdata = new FormData()

function get_data () {
    formdata.append("funcion", "get_data")
    opciones.body = formdata
    fetch('consulta.php', opciones)
        .then(respuesta => respuesta.json())
        .then(resultado => {
            let template = ``
            resultado.forEach(elemento => {

                template += `
                            <tr>
                                <th>
                                    <input type="checkbox" value="${elemento.id}"  class="checkboxes">
                                </th>
                                <td>${elemento.correo}</td>
                                <td>${elemento.passwords}</td>
                                <td>${elemento.nombre}</td>
                                <td>${elemento.rol}</td>
                                <td>${elemento.status}</td>
                                <td>
                                <a href="#" class="btn_editar">Editar</a>
                                </td>
                                
                            </tr>
                            
                    `
            });
            tabla.innerHTML = template
        });
}
get_data()
btnNew.addEventListener("click", (event) => {
    event.preventDefault()
    if (data.style.display != "none") {
        data.style.display = "none"
        insert_data.style.display = "block"
    }

})
btnSave.addEventListener("click", (event) => {
    event.preventDefault()
    if (nombre.value != "" && passwords.value != "" && rol.value != "" && status.value != "" && correo.value != "") {
        let formdata = new FormData(form)
        formdata.append("funcion", "insert_data")
        opciones.body = formdata
        fetch('consulta.php', opciones)
            .then(respuesta => respuesta.json())
            .then(resultado => {
                alert(resultado.text)
                if (resultado.status == "success") {
                    data.style.display = "block"
                    form.reset()
                    insert_data.style.display = "none"
                    get_data()
                }
            })
    }
})
SelectAll.addEventListener("change", checkbox => {
    const checkboxes = document.querySelectorAll(".checkboxes")
    checkboxes.forEach(element => {
        element.checked = false
    })
    if (SelectAll.checked) {
        checkboxes.forEach(element => {
            element.checked = true
        })
    }
    showDeleteIcon()
})
const isSelected = item => item.checked
const showDeleteIcon = () => {
    const checkboxes = document.querySelectorAll(".checkboxes")
    const arrayCheckboxes = Array.from(checkboxes)
    const someChecked = arrayCheckboxes.some(isSelected)
    btnBorrar.style.display = "none"
    if (someChecked) {
        btnBorrar.style.display = "inline-block"
    }
}
tabla.addEventListener("click", event => {
    if (event.target.classList.contains('btn_editar')) {

    }
    if (event.target.classList.contains('checkboxes')) {
        showDeleteIcon()
    }
})

btnBorrar.addEventListener("click", event => {
    event.preventDefault()
    const confirmDelete = confirm("Estás seguro de borrar los datos?")
    if (confirmDelete) {
        const checkboxes = document.querySelectorAll(".checkboxes")
        const arrayCheckboxes = Array.from(checkboxes)
        const itemsCheckbox = arrayCheckboxes
            .filter(checkbox => checkbox.checked)
            .map(checkbox => checkbox.value)

        const formData = new FormData()
        formData.append("funcion", "delete_data")
        formData.append("data", itemsCheckbox)
        fetch("consulta.php", {
            method: "POST",
            body: formData
        })
            .then(response => response.json())
            .then(json => {
                if (json.status == "success") {
                    get_data()
                }
            })
    }
})