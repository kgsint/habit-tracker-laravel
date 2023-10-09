import axios from "axios";
import Swal from "sweetalert2";

// select all delete btns
document.querySelectorAll('#delete-btn').forEach(btn => {
    // click event
    btn.addEventListener('click', (e) => {
        // get data from data-habit attribute
        const habit = JSON.parse(e.currentTarget.dataset.habit)
        // console.log(habit)

        // sweet alert modal
        Swal.fire({
            text: `Do you want to delete "${habit.title}"?`,
            showCancelButton: true,
            confirmButtonText: 'Delete',
            confirmButtonColor: '#cf2e0a'
        }).then((result) => {
            // delete if confirmed
          if (result.isConfirmed) {
            // delete request
            axios.delete(`/habits/${habit.id}`)

            location.href = "/"
          }
        })
    })
})
