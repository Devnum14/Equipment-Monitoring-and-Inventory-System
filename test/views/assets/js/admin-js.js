const toggler = document.querySelector('.btn')
toggler.addEventListener('click', function () {
  document.querySelector('#sidebar').classList.toggle('collapsed')
  const icon = document.querySelector('.btn i')
  icon.classList.toggle('fa-x')
  icon.classList.toggle('fa-bars')
})
