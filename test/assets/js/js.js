function validateEmail (email) {
  const regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/
  return regex.test(email)
}

$('#signup').on('click', function () {
  // Get the values of the form fields
  var name = document.forms['signupform']['name'].value
  var username = document.forms['signupform']['username'].value
  var email = document.forms['signupform']['email'].value
  var password = document.forms['signupform']['password'].value
  var retypepassword = document.forms['signupform']['retypepassword'].value
  var selectedUserType = $('#usertype').val() // Get the selected value, not text

  // Call the validation function and pass the form values
  if (
    signup_validation(name, username, email, password, retypepassword, selectedUserType)
  ) {
    // If validation succeeds, you can proceed with form submission
    $.ajax({
      type: 'POST',
      url: '_function.php',
      data: {
        form: 'signup',
        name: name,
        username: username,
        email: email,
        password: password,
        usertype: selectedUserType
      },
      success: function (response) {
        if (response === 'Email has been used') {
          toastr.error('Email has been used')
        }
        else if (response === 'Username has been used') {
          toastr.error('Username has been used')
        }
        else {
          window.location.href = '/test/index.php'
        }
      }
    })
  }
})

function signup_validation (
  name,
  username,
  email,
  password,
  retypepassword,
  selectedUserType
) {
  // Reset toastr options to avoid duplication in each if block
  toastr.options = {
    closeButton: true,
    debug: false,
    newestOnTop: false,
    progressBar: true,
    positionClass: 'toast-top-right',
    preventDuplicates: false,
    onclick: null,
    showDuration: '300',
    hideDuration: '1000',
    timeOut: '3000',
    extendedTimeOut: '1000',
    showEasing: 'swing',
    hideEasing: 'linear',
    showMethod: 'fadeIn',
    hideMethod: 'fadeOut'
  }
  

  if (name === '') {
    toastr.error('Please input name field')
    return false // Return false to indicate validation failure
  }

  if (username === '') {
    toastr.error('Please input Username field')
    return false
  }

  if (email === '') {
    toastr.error('Please input email field')
    return false
  }

  if (password === '') {
    toastr.error('Please input password field')
    return false
  }

  if (retypepassword === '') {
    toastr.error('Please input confirm password field')
    return false
  }

  if (selectedUserType === '') {
    // Check against the default option's value
    toastr.error('Please select User')
    return false
  }

  if (password !== retypepassword) {
    toastr.error('Password and Confirm Password not match')
    return false
  }

  if (!validateEmail(email)) {
    toastr.error('Invalid email address')
    return false
  }

  // Custom validation logic can be added here, e.g., checking if passwords match

  return true // If all validation checks pass, return true to indicate success
}

$('#signin').on('click', function () {
  const username = document.forms['signinform']['username'].value
  const password = document.forms['signinform']['password'].value

  if (signin_validation(username, password)) {
    $.ajax({
      type: 'POST',
      url: '_function.php',
      data: {
        form: 'signin',
        username: username,
        password: password,
      },
      success: function (response) {
        if (response === 'failed') {
          toastr.error('Incorrect Username or Password.')
        } else if (response === 'no account') {
          toastr.error('No Account In That Username')
        } else {
          window.location.href = '/test/views/admin/dashboard'
        }
      }
    })
  }
})

function signin_validation (username, password) {
  // Reset toastr options to avoid duplication in each if block
  toastr.options = {
    closeButton: true,
    debug: false,
    newestOnTop: false,
    progressBar: true,
    positionClass: 'toast-top-right',
    preventDuplicates: false,
    onclick: null,
    showDuration: '300',
    hideDuration: '1000',
    timeOut: '3000',
    extendedTimeOut: '1000',
    showEasing: 'swing',
    hideEasing: 'linear',
    showMethod: 'fadeIn',
    hideMethod: 'fadeOut'
  }

  
  if (username === '') {
    toastr.error('Please input Username')
    return false
  }

  if (password === '') {
    toastr.error('Please input password field')
    return false
  }



  return true
}
