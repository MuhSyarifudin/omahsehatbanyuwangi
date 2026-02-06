const jenisLayananSelect = document.getElementById('jenisLayanan');
const alamatSection = document.getElementById('alamatSection');

document.addEventListener('DOMContentLoaded', () => {

  const nohpInput = document.querySelector('input[name="nohp"]')

  nohpInput.addEventListener('input', () => {
    let value = nohpInput.value

    const hasPlus = value.startsWith('+')

    value = value.replace(/\D/g, '')

    if (value.length > 15) {
      value = value.slice(0, 15)
    }

    nohpInput.value = hasPlus ? '+' + value : value
  })

})

document.addEventListener('DOMContentLoaded', () => {

  const fields = document.querySelectorAll('input, select, textarea')

  const regexHP = /^(?:\+?[1-9]\d{7,14}|0\d{9,13})$/

  fields.forEach(field => {
    field.addEventListener('input', () => clearError(field))
    field.addEventListener('change', () => clearError(field))
  })

  function clearError(field) {
    const formControl = field.closest('.form-control')
    if (!formControl) return

    if (field.name === 'nohp') {
      const value = field.value.trim()

      if (value !== '' && !regexHP.test(value)) {
        return
      }
    }

    field.classList.remove('border', 'border-red-500')

    const errorText = formControl.querySelector('.text-error')
    if (errorText) {
      errorText.remove()
    }
  }
})

document.addEventListener('DOMContentLoaded', () => {
  const nohpInput = document.querySelector('input[name="nohp"]')

  const regexHP = /^(?:\+?[1-9]\d{7,14}|0\d{9,13})$/

  nohpInput.addEventListener('input', () => {
    const value = nohpInput.value.trim()
    const formControl = nohpInput.closest('.form-control')

    clearError(formControl, nohpInput)

    if (value === '') return

    if (!regexHP.test(value)) {
      showError(
        formControl,
        nohpInput,
        'Nomor WhatsApp tidak valid. format nomor internasional atau indonesia (maks. 15 digit)'
      )
    }
  })

  function showError(wrapper, input, message) {
    input.classList.add('border', 'border-red-500')

    if (wrapper.querySelector('.text-error')) return

    const error = document.createElement('span')
    error.className = 'text-error text-xs'
    error.innerHTML = `ⓘ ${message}`
    wrapper.appendChild(error)
  }

  function clearError(wrapper, input) {
    input.classList.remove('border', 'border-red-500')

    const error = wrapper.querySelector('.text-error')
    if (error) error.remove()
  }
})

function toggleAlamatSection() {
    if (jenisLayananSelect.value === 'homecare') {
        alamatSection.style.display = 'block';
    } else {
        alamatSection.style.display = 'none';
    }
}

jenisLayananSelect.addEventListener('change', toggleAlamatSection);

document.addEventListener('DOMContentLoaded', toggleAlamatSection);

 
const header = document.getElementById('header');

window.addEventListener('scroll', () => {
    if (window.scrollY > 50) {
        header.classList.add('fixed');
    } else {
        header.classList.remove('fixed');
    }
});

document.addEventListener('DOMContentLoaded', function () {

  let jamTerpakai = {}
  let layananAktif = null
  let tanggalAktif = null
  let jamAktif = null

  const tanggalPicker = document.getElementById('tanggalPicker')
  const jamSelect = document.getElementById('jam')
  const jenisLayananSelect = document.getElementById('jenisLayanan')
  const hariInput = document.getElementById('hari')
  const tanggalHelp = document.getElementById('tanggalHelp')
  const jamHelp = document.getElementById('jamHelp')

  tanggalPicker.disabled = true
  jamSelect.disabled = true

  tanggalHelp.textContent = 'Pilih jenis layanan terlebih dahulu'
  jamHelp.textContent = 'Pilih tanggal untuk melihat jam tersedia'

   function disableJamLewat() {
      if (!tanggalAktif) return

      const today = new Date()
      const todayStr = today.toISOString().split('T')[0]

      if (tanggalAktif !== todayStr) return

      const currentHour = today.getHours()

      document.querySelectorAll('#jam option').forEach(option => {
          if (!option.value) return

          const jamOption = parseInt(option.value.split(':')[0])

          if (jamOption <= currentHour) {
              option.disabled = true
              option.textContent = option.value + ' (Lewat)'
              option.setAttribute('title', 'Jam sudah lewat')
              option.classList.add('bg-slate-100','cursor-not-allowed')
          }
      })
  }


  async function loadJamTerpakai() {
      const res = await fetch('/jam-terpakai')
      jamTerpakai = await res.json()
      applyBookedJam()
      disableJamLewat()
  }

  function generateJam(hari) {
      jamSelect.innerHTML = '<option value="">Pilih Jam</option>'

      let jamAwal = 8
      let jamAkhir = 20

      if (hari === 'Jumat' || hari === 'Sabtu') jamAkhir = 14

      if (hari === 'Minggu') {
          jamSelect.innerHTML = '<option value="">Libur</option>'
          jamSelect.disabled = true
          return
      }

      for (let i = jamAwal; i <= jamAkhir; i++) {
          const jam = i.toString().padStart(2, '0') + ':00'
          jamSelect.insertAdjacentHTML(
              'beforeend',
              `<option value="${jam}">${jam}</option>`
          )
      }

      jamSelect.disabled = false
  }

  function resetJam() {
      jamSelect.innerHTML = '<option value="">Pilih Jam</option>'
      jamSelect.disabled = true
      jamAktif = null
  }

  jenisLayananSelect.addEventListener('change', function () {

    layananAktif = this.value.toLowerCase()

    tanggalAktif = null
    jamAktif = null

    fp.clear()
    tanggalPicker.disabled = false
    fp.set('clickOpens', true)

    if (hariInput) hariInput.value = ''

    tanggalHelp.textContent = 'Silakan pilih tanggal reservasi'
    jamHelp.textContent = 'Pilih tanggal untuk melihat jam tersedia'

    resetJam()
    loadJamTerpakai()
  })

  function applyBookedJam() {
      if (!layananAktif || !tanggalAktif) return

      const booked = jamTerpakai[layananAktif]?.[tanggalAktif] ?? []

      document.querySelectorAll('#jam option').forEach(option => {
          if (!option.value) return
          if (booked.includes(option.value)) {
              option.disabled = true
              option.textContent = option.value + ' (Booked)'
              option.setAttribute('title','Sudah dibooking')
              option.classList.add('bg-slate-100','cursor-not-allowed')
          }
      })
  }

  const fp = flatpickr(tanggalPicker, {
      dateFormat: 'Y-m-d',
      minDate: 'today',
      maxDate: new Date().fp_incr(3),
      disable: [d => d.getDay() === 0],
      locale: { firstDayOfWeek: 1 },
      clickOpens: false,
      onChange(selectedDates, dateStr) {

          if (!selectedDates.length) return

          tanggalAktif = dateStr

          const hari = selectedDates[0].toLocaleDateString('id-ID', {
              weekday: 'long'
          })

          if (hariInput) hariInput.value = hari

          generateJam(hari)
          loadJamTerpakai()
          disableJamLewat()


          tanggalHelp.textContent = 'Tanggal dipilih ✔'
          tanggalHelp.classList.remove('text-slate-500');
          tanggalHelp.classList.add('text-green-600');

          jamHelp.classList.remove('text-green-600')
          jamHelp.classList.add('text-slate-500')
          jamHelp.textContent = 'Pilih jam yang tersedia'
      }
  })

  jenisLayananSelect.addEventListener('change', function () {

      layananAktif = this.value.toLowerCase()

      tanggalAktif = null
      jamAktif = null

      fp.clear()
      tanggalPicker.disabled = false
      fp.set('clickOpens', true)

      if (hariInput) hariInput.value = ''

      tanggalHelp.classList.remove('text-green-600')
      tanggalHelp.classList.add('text-slate-500')
      
      jamHelp.classList.remove('text-green-600')
      jamHelp.classList.add('text-slate-500')

      resetJam()
      loadJamTerpakai()
  })

  jamSelect.addEventListener('change', function () {
      jamAktif = this.value
      jamSelect.disabled = false

      if (jamAktif) {
        jamHelp.textContent = 'Jam dipilih ✔'
        jamHelp.classList.remove('text-slate-500')
        jamHelp.classList.add('text-green-600')

        setTimeout(() => {
          jamHelp.textContent = ''
          tanggalHelp.textContent = ''
        }, 2000);
    }
  })

})