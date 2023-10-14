import axios from "axios"

// check or uncheck task
document.querySelectorAll('#task-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', e => {
        // update task
        updateTask(e)

    })
})

// when hit enter from task input, Update
document.querySelectorAll('#taskUpdateForm input[type="text"]').forEach(input => {
    input.addEventListener('keydown', e => {
        // when press enter
        if(e.key === 'Enter') {
            // prevent reload when the user hit enter
            e.preventDefault()
            // update task
            updateTask(e)
        }

    })
})

// reusable utils function
function updateTask(e) {
    const form = e.currentTarget.closest('form')
    const formData = new FormData(form)

    const data = Object.fromEntries(formData.entries())

    // form has @method('PATCH) => _method="PATCH"  so it's typically patch request,
    axios.post(form.action, data).then(res => {
        if(res.status === 200) {
            location.reload()
        }
    })
}
