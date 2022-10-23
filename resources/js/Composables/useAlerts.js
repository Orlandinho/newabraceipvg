import Swal from "sweetalert2";

export function useAlerts(title, message, icon) {

    const toastAlert = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true
    })

    toastAlert.fire({
        title: title,
        text: message,
        icon: icon,
    })

    return toastAlert
}
