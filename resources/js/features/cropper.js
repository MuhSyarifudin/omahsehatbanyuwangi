import Cropper from "cropperjs";
import "cropperjs/dist/cropper.css";

export default function initProfileCropper() {
    initImageCropper({
        inputId: 'photoInput',
        modalId: 'cropModal',
        imageId: 'imagePreview',
        previewIds: ['avatarPreview', 'avatarPreview2','foto-profil'],
        saveButtonId: 'saveCrop',
        cancelButtonId: 'cancelCrop',
        rotateLeftButtonId: 'rotateLeft',
        rotateRightButtonId: 'rotateRight',
        zoomSliderId: 'zoomSlider',
        endpoint: '/api/profile/photo',
        fieldName: 'photo',
        aspectRatio: 1,
        canvasWidth: 500,
        canvasHeight: 500,
    });

    initImageCropper({
        inputId: 'backgroundInput',
        modalId: 'backgroundCropModal',
        imageId: 'backgroundImagePreview',
        previewIds: ['backgroundPreview'],
        saveButtonId: 'backgroundSaveCrop',
        cancelButtonId: 'backgroundCancelCrop',
        rotateLeftButtonId: 'backgroundRotateLeft',
        rotateRightButtonId: 'backgroundRotateRight',
        zoomSliderId: 'backgroundZoomSlider',
        endpoint: '/api/profile/background',
        fieldName: 'background',
        aspectRatio: 16 / 7,
        canvasWidth: 1600,
        canvasHeight: 700,
    });

    initPreviousProfilePhotoPicker();
    initPreviousProfilePhotoDeleter();
}

function initImageCropper(config) {
    let cropper;

    const input = document.getElementById(config.inputId);
    const modal = document.getElementById(config.modalId);
    const image = document.getElementById(config.imageId);
    const saveBtn = document.getElementById(config.saveButtonId);
    const cancelBtn = document.getElementById(config.cancelButtonId);
    const rotateLeftBtn = document.getElementById(config.rotateLeftButtonId);
    const rotateRightBtn = document.getElementById(config.rotateRightButtonId);
    const zoomSlider = document.getElementById(config.zoomSliderId);

    if (!input || !modal || !image) return;

    function openModal() {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeModal() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    function destroyCropper() {
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
    }

    input.addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (!file) return;

        const reader = new FileReader();

        reader.onload = function (event) {
            image.src = event.target.result;

            image.onload = function () {
                openModal();
                destroyCropper();

                cropper = new Cropper(image, {
                    aspectRatio: config.aspectRatio,
                    viewMode: 1,
                    autoCropArea: 1,
                    responsive: true,
                    background: false,
                    movable: true,
                    zoomable: true,
                    rotatable: true,
                    scalable: false,
                });

                if (zoomSlider) {
                    zoomSlider.value = 0;
                }
            };
        };

        reader.readAsDataURL(file);
    });

    if (rotateLeftBtn) {
        rotateLeftBtn.addEventListener('click', () => {
            if (!cropper) return;
            cropper.rotate(-90);
        });
    }

    if (rotateRightBtn) {
        rotateRightBtn.addEventListener('click', () => {
            if (!cropper) return;
            cropper.rotate(90);
        });
    }

    if (zoomSlider) {
        zoomSlider.addEventListener('input', function () {
            if (!cropper) return;
            cropper.zoomTo(parseFloat(this.value));
        });
    }

    if (saveBtn) {
        saveBtn.addEventListener('click', function () {
            if (!cropper) return;

            const canvas = cropper.getCroppedCanvas({
                width: config.canvasWidth,
                height: config.canvasHeight,
                imageSmoothingQuality: 'high',
            });

            canvas.toBlob(function (blob) {
                const formData = new FormData();
                formData.append(config.fieldName, blob);
                formData.append(
                    '_token',
                    document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                );

                fetch(config.endpoint, {
                    method: 'POST',
                    body: formData,
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.url) {
                            config.previewIds.forEach((previewId) => {
                                const preview = document.getElementById(previewId);

                                if (preview) {
                                    preview.src = data.url;
                                }
                            });
                        }

                        destroyCropper();
                        closeModal();
                        input.value = '';
                    });
            }, 'image/jpeg', 0.9);
        });
    }

    if (cancelBtn) {
        cancelBtn.addEventListener('click', function () {
            destroyCropper();
            input.value = '';
            closeModal();
        });
    }
}

const PROFILE_PREVIEW_IDS = ['avatarPreview', 'avatarPreview2', 'foto-profil'];

function updateProfilePreview(url) {
    PROFILE_PREVIEW_IDS.forEach((previewId) => {
        const preview = document.getElementById(previewId);

        if (preview) {
            preview.src = url;
        }
    });
}

const ACTIVE_PHOTO_BUTTON_CLASSES = {
    active: ['border-primary', 'shadow-lg', 'shadow-primary/20'],
    inactive: ['border-gray-100', 'hover:border-gray-300'],
};

let profilePhotoDeleteToggleLock = false;

function shouldUseTapToShowDelete() {
    return window.matchMedia('(max-width: 1023px), (hover: none)').matches;
}

function syncDeleteButtonVisibility(item) {
    const deleteBtn = item?.querySelector('.delete-profile-photo');
    if (!deleteBtn) return;

    const showOnMobile =
        shouldUseTapToShowDelete()
        && item.classList.contains('is-active')
        && item.classList.contains('show-delete');

    if (showOnMobile) {
        deleteBtn.style.opacity = '1';
        deleteBtn.style.pointerEvents = 'auto';
        deleteBtn.style.transform = 'scale(1)';
        return;
    }

    deleteBtn.style.opacity = '';
    deleteBtn.style.pointerEvents = '';
    deleteBtn.style.transform = '';
}

function syncAllDeleteButtonsVisibility() {
    document.querySelectorAll('.profile-photo-item').forEach(syncDeleteButtonVisibility);
}

function closeAllProfilePhotoDeleteToggles() {
    document.querySelectorAll('.profile-photo-item.show-delete').forEach((item) => {
        item.classList.remove('show-delete');
        syncDeleteButtonVisibility(item);
    });
}

function toggleActivePhotoDeleteOnMobile(item) {
    if (!shouldUseTapToShowDelete() || !item?.classList.contains('is-active')) {
        return false;
    }

    const willShow = !item.classList.contains('show-delete');
    closeAllProfilePhotoDeleteToggles();
    item.classList.toggle('show-delete', willShow);
    syncDeleteButtonVisibility(item);

    profilePhotoDeleteToggleLock = true;
    window.setTimeout(() => {
        profilePhotoDeleteToggleLock = false;
    }, 400);

    return true;
}

function setProfilePhotoButtonActive(button, isActive) {
    button.classList.remove(...ACTIVE_PHOTO_BUTTON_CLASSES.active, ...ACTIVE_PHOTO_BUTTON_CLASSES.inactive);

    if (isActive) {
        button.classList.add(...ACTIVE_PHOTO_BUTTON_CLASSES.active);
        return;
    }

    button.classList.add(...ACTIVE_PHOTO_BUTTON_CLASSES.inactive);
}

function clearActiveProfilePhotoBadges() {
    document.querySelectorAll('.profile-photo-item').forEach((item) => {
        const button = item.querySelector('.previous-profile-photo');

        item.classList.remove('is-active', 'show-delete');
        item.querySelector('.profile-photo-active-badge')?.remove();
        syncDeleteButtonVisibility(item);

        if (button) {
            setProfilePhotoButtonActive(button, false);
        }
    });
}

function markProfilePhotoAsActive(item) {
    clearActiveProfilePhotoBadges();

    const selectButton = item.querySelector('.previous-profile-photo');
    if (!selectButton) return;

    item.classList.add('is-active');
    setProfilePhotoButtonActive(selectButton, true);

    if (selectButton.querySelector('.profile-photo-active-badge')) return;

    selectButton.insertAdjacentHTML(
        'beforeend',
        '<span class="profile-photo-active-badge absolute bottom-2 left-1/2 -translate-x-1/2 z-10 px-2.5 py-1 rounded-full bg-primary text-white text-[10px] font-semibold shadow-lg transition-opacity duration-200 group-hover:opacity-0">Aktif</span>'
    );
}

function initPreviousProfilePhotoPicker() {
    const buttons = document.querySelectorAll('.previous-profile-photo');
    if (!buttons.length) return;

    if (!document.body.dataset.profilePhotoPickerBound) {
        document.body.dataset.profilePhotoPickerBound = '1';

        document.addEventListener('click', (event) => {
            if (profilePhotoDeleteToggleLock) return;
            if (event.target.closest('.delete-profile-photo')) return;
            if (event.target.closest('.profile-photo-item')) return;
            closeAllProfilePhotoDeleteToggles();
        });

        window.addEventListener('resize', syncAllDeleteButtonsVisibility);
    }

    buttons.forEach((button) => {
        button.addEventListener('click', function (event) {
            event.stopPropagation();

            const item = this.closest('.profile-photo-item');
            const path = item?.dataset.photoPath;
            if (!path) return;

            if (toggleActivePhotoDeleteOnMobile(item)) {
                return;
            }

            closeAllProfilePhotoDeleteToggles();

            const formData = new FormData();
            formData.append('path', path);
            formData.append(
                '_token',
                document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            );

            fetch('/api/profile/photo/select', {
                method: 'POST',
                body: formData,
            })
                .then(response => response.json())
                .then(data => {
                    if (!data.url) return;

                    updateProfilePreview(data.url);

                    if (item) {
                        markProfilePhotoAsActive(item);
                    }
                });
        });
    });

    syncAllDeleteButtonsVisibility();
}

function initPreviousProfilePhotoDeleter() {
    const deleteButtons = document.querySelectorAll('.delete-profile-photo');
    if (!deleteButtons.length) return;

    deleteButtons.forEach((button) => {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            event.stopPropagation();

            const item = this.closest('.profile-photo-item');
            const path = item?.dataset.photoPath;
            if (!path) return;

            if (!confirm('Hapus foto profile ini?')) return;

            const formData = new FormData();
            formData.append('path', path);
            formData.append(
                '_token',
                document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            );

            fetch('/api/profile/photo/delete', {
                method: 'POST',
                body: formData,
            })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error('Gagal menghapus foto.');
                    }

                    return response.json();
                })
                .then((data) => {
                    closeAllProfilePhotoDeleteToggles();
                    item?.remove();

                    const grid = document.getElementById('previousProfilePhotosGrid');
                    if (grid && !grid.querySelector('.profile-photo-item')) {
                        grid.closest('.mt-4')?.remove();
                    }

                    if (data.avatar_url) {
                        updateProfilePreview(data.avatar_url);
                    }

                    if (data.avatar) {
                        const activeItem = document.querySelector(
                            `.profile-photo-item[data-photo-path="${data.avatar}"]`
                        );
                        if (activeItem) {
                            markProfilePhotoAsActive(activeItem);
                        }
                    } else {
                        clearActiveProfilePhotoBadges();
                    }
                })
                .catch(() => {
                    alert('Gagal menghapus foto profile. Silakan coba lagi.');
                });
        });
    });
}
