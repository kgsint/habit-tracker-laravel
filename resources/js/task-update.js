import axios from "axios"

document.querySelectorAll('#task-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', e => {
        const form = e.currentTarget.closest('form')
        const formData = new FormData(form)

        const data = Object.fromEntries(formData.entries())

        // form has @method('PATCH) => _method="PATCH"  so it's typically patch request,
        axios.post(form.action, data)

        location.reload()
    })
})
