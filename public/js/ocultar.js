$(document).ready(function() {

    $('#submit-form-login').on('click', function() {
        $('#password').attr('type', 'password');
    });
  

    $('#submit-form-create').on('click', function() {
        $('#password_create').attr('type', 'password');
        $('#password_confirmation').attr('type', 'password');

    });

    // Click event of the showPassword button
    $('#showSenha').on('click', function() {
        
        // Get the password field
        var passwordField = $('#password');

        // Get the current type of the password field will be password or text
        var passwordFieldType = passwordField.attr('type');

        // Check to see if the type is a password field
        if (passwordFieldType == 'password') {
            // Change the password field to text
            passwordField.attr('type', 'text');

            // Change the Text on the show password button to Hide
            $(this).val('Ocultar senha');
        } else {
            // If the password field type is not a password field then set it to password
            passwordField.attr('type', 'password');

            // Change the value of the show password button to Show
            $(this).val('Mostrar senha');
        }
    });


      // Click event of the showPassword button
      $('#showSenhaCreate').on('click', function() {

        // Get the password field
        var passwordField = $('#password_create');
        var passwordConfField = $('#password_confirmation');



        // Get the current type of the password field will be password or text
        var passwordFieldType = passwordField.attr('type');
        var passwordConfiFieldType = passwordConfField.attr('type');

        // Check to see if the type is a password field
        if (passwordFieldType == 'password' || passwordConfiFieldType == 'password') {
            // Change the password field to text
            passwordField.attr('type', 'text');
            passwordConfField.attr('type', 'text');

            // Change the Text on the show password button to Hide
            $(this).val('Ocultar senhas');
        } else {
            // If the password field type is not a password field then set it to password
            passwordField.attr('type', 'password');
            passwordConfField.attr('type', 'password');


            // Change the value of the show password button to Show
            $(this).val('Mostrar senhas');
        }
    });
});