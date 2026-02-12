import Cropper from "cropperjs";
import "cropperjs/dist/cropper.css";

export default function initProfileCropper() {

    let cropper;
    
    const input = document.getElementById('photoInput')
    const modal = document.getElementById('cropModal')
    const image = document.getElementById('imagePreview')
    const avatarPreview = document.getElementById('avatarPreview')
    const saveBtn = document.getElementById('saveCrop')
    const cancelBtn = document.getElementById('cancelCrop')
    const croppedInput = document.getElementById('croppedPhoto')

    if (!input || !modal) return
    
    function openModal() {
        modal.classList.remove('hidden')
        modal.classList.add('flex')
    }
    
    function closeModal() {
        modal.classList.add('hidden')
        modal.classList.remove('flex')
    }
    
    function destroyCropper() {
        if (cropper) {
            cropper.destroy()
            cropper = null
        }
    }
    
    input.addEventListener('change', function (e) {
    
        const file = e.target.files[0]
        if (!file) return
    
        const reader = new FileReader()
    
        reader.onload = function (event) {
    
            image.src = event.target.result
    
            image.onload = function () {
    
                openModal()
                destroyCropper()
    
                cropper = new Cropper(image, {
                    aspectRatio: 1,
                    viewMode: 1,
                    autoCropArea: 1,
                    responsive: true,
                    background: false,
                    movable: true,
                    zoomable: true,
                    scalable: false,
                    rotatable: false,
                })
            }
        }
    
        reader.readAsDataURL(file)
    })
    
    saveBtn.addEventListener('click', function () {
    
    if (!cropper) return
    
    const canvas = cropper.getCroppedCanvas({
        width: 500,
        height: 500,
        imageSmoothingQuality: 'high'
    })
    
    canvas.toBlob(function (blob) {
    
        const formData = new FormData()
        formData.append('photo', blob)
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'))
    
        fetch('/api/profile/photo', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
    
            avatarPreview.src = data.url
    
            cropper.destroy()
            cropper = null
    
            modal.classList.add('hidden')
            modal.classList.remove('flex')
            input.value = ''
        })
    
    }, 'image/jpeg', 0.9)
    
    })
    
    cancelBtn.addEventListener('click', function () {
        destroyCropper()
        input.value = ''
        closeModal()
    })
    
    }