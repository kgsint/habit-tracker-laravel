import axios from "axios"

document.querySelectorAll('#task-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', e => {
        const form = e.currentTarget.closest('form')
        const formData = new FormData(form)

        const data = Object.fromEntries(formData.entries())

        // request with axios
        axios.patch(form.action, data)

        location.reload()
    })
})
