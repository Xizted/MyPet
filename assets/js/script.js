(function () {
  /**
   * Schema del formulario del register
   */
  var userValuesRegister = {
    username: '',
    email: '',
    password: '',
    passwordConfirm: '',
  };

  /**
   * Schema del formulario del login
   */

  var userValuesLogin = {
    email: '',
    password: '',
  };

  /**
   * Schema del formulario del register
   */
  var addPetValues = {
    name: '',
    weight: '',
    breed: '',
    specie: '',
  };

  /**
   * Almacenar valores de los formularios
   */

  var inputsValues = {};

  /**
   * Validar Email
   */

  var validateEmail = function (email) {
    return /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(
      email
    );
  };

  /**
   * Mostrar errores en los formularios
   */

  var showErrors = function (errors) {
    var errorsUnique = errors.reduce(function (unique, o) {
      if (!unique.some((obj) => obj.type === o.type)) {
        unique.push(o);
      }
      return unique;
    }, []);

    errorsUnique.forEach((error) => {
      var input = document.querySelector(`input[name="${error.type}"]`);
      input.classList.add('error');
      var div = document.createElement('small');
      div.textContent = error.message;
      div.classList.add('invalid-feedback', 'd-block', 'm-0');
      input.parentNode.appendChild(div);
      var time = setTimeout(function () {
        input.classList.remove('error');
        div.remove();
        clearTimeout(time);
      }, 2000);
    });
  };

  /**
   * Captura valores de los formularios
   */

  var getValues = function (valuesCapture) {
    var inputs = document.querySelectorAll('input');
    inputsValues = valuesCapture;
    inputs.forEach(function (input) {
      inputsValues = {
        ...inputsValues,
        [input.name]: input.value,
      };

      input.addEventListener('input', function (e) {
        inputsValues = {
          ...inputsValues,
          [e.target.name]: e.target.value,
        };
      });
    });
  };

  /**
   * Validar los datos del formulario de login
   */

  var validationLogin = function () {
    var formLogin = document.querySelector('.login form');
    if (!formLogin) {
      return;
    }

    getValues(userValuesLogin);
    formLogin.addEventListener('submit', function (e) {
      e.preventDefault();
      var errors = [];

      if (!inputsValues.email) {
        errors = [
          ...errors,
          { message: 'El email es requerido', type: 'email' },
        ];
      }

      if (!validateEmail(inputsValues.email)) {
        errors = [...errors, { message: 'Email no valido', type: 'email' }];
      }

      if (!inputsValues.password) {
        errors = [
          ...errors,
          { message: 'La contraseña es requerida', type: 'password' },
        ];
      }

      if (inputsValues.password.trim().length < 8) {
        errors = [
          ...errors,
          { message: 'La contraseña es muy corta', type: 'password' },
        ];
      }

      if (errors.length > 0) {
        showErrors(errors);
        return;
      }

      formLogin.submit();
    });
  };

  /**
   * Validar los datos del formulario de registro
   */

  var validationRegister = function () {
    var formRegister = document.querySelector('.register form');
    if (!formRegister) {
      return;
    }
    getValues(userValuesRegister);
    formRegister.addEventListener('submit', function (e) {
      e.preventDefault();

      var errors = [];

      if (!inputsValues.username) {
        errors = [
          ...errors,
          { message: 'El usuario es requerido', type: 'username' },
        ];
      }

      if (
        inputsValues.username.trim().length < 3 ||
        inputsValues.username > 10
      ) {
        errors = [
          ...errors,
          {
            message:
              'El usuario debe de tener al menos 3 caracteres y máximo 10',
            type: 'username',
          },
        ];
      }

      if (!inputsValues.email) {
        errors = [
          ...errors,
          { message: 'El email es requerido', type: 'email' },
        ];
      }

      if (!validateEmail(inputsValues.email)) {
        errors = [...errors, { message: 'Email no valido', type: 'email' }];
      }

      if (!inputsValues.password) {
        errors = [
          ...errors,
          { message: 'La contraseña es requerida', type: 'password' },
        ];
      }

      if (inputsValues.password.trim().length < 8) {
        errors = [
          ...errors,
          { message: 'La contraseña es muy corta', type: 'password' },
        ];
      }

      if (!inputsValues.passwordConfirm) {
        errors = [
          ...errors,
          {
            message: 'La confirmación de la contraseña es requerida',
            type: 'passwordConfirm',
          },
        ];
      }

      if (inputsValues.password != inputsValues.passwordConfirm) {
        errors = [
          ...errors,
          {
            message: 'Las contraseñas no son iguales',
            type: 'passwordConfirm',
          },
        ];
      }

      if (errors.length > 0) {
        showErrors(errors);
        return;
      }

      formRegister.submit();
    });
  };

  /**
   * Validar los datos del formulario de addPet
   */

  var validationAddPet = function () {
    var formLogin = document.querySelector('.addPet form');
    if (!formLogin) {
      return;
    }
    getValues(addPetValues);
    formLogin.addEventListener('submit', function (e) {
      e.preventDefault();

      var errors = [];
      if (!inputsValues.name) {
        errors = [
          ...errors,
          { message: 'El nombre es requerido', type: 'name' },
        ];
      }

      if (
        inputsValues.name.trim().length < 3 ||
        inputsValues.name.trim().length > 10
      ) {
        errors = [
          ...errors,
          {
            message:
              'El nombre debe de tener al menos 3 caracteres y máximo 10',
            type: 'name',
          },
        ];
      }

      if (!inputsValues.weight) {
        errors = [
          ...errors,
          { message: 'El peso es requerido', type: 'weight' },
        ];
      }

      if (inputsValues.weight < 0 || inputsValues.weight > 80) {
        errors = [
          ...errors,
          { message: 'El peso debe ser mayor a 0 y menor a 80' },
        ];
      }

      if (!inputsValues.breed) {
        errors = [
          ...errors,
          { message: 'La raza es requerida', type: 'breed' },
        ];
      }

      if (
        inputsValues.breed.trim().length < 3 ||
        inputsValues.breed.trim().length > 10
      ) {
        errors = [
          ...errors,
          {
            message: 'La raza debe de tener al menos 3 caracteres y máximo 10',
            type: 'breed',
          },
        ];
      }

      if (!inputsValues.specie) {
        errors = [
          ...errors,
          { message: 'La especie es requerida', type: 'specie' },
        ];
      }

      if (
        inputsValues.specie.trim().length < 3 ||
        inputsValues.specie.trim().length > 10
      ) {
        errors = [
          ...errors,
          {
            message:
              'La especie debe de tener al menos 3 caracteres y máximo 10',
            type: 'specie',
          },
        ];
      }
      console.log(inputsValues);

      if (errors.length > 0) {
        showErrors(errors);
        return;
      }

      formLogin.submit();
    });
  };

  /**
   * Remover alerta despues de 3 segundos
   */

  var removeAlert = function () {
    var alert = document.querySelector('.alert:not(.alert-info)');
    if (!alert) {
      return;
    }

    var time = setTimeout(() => {
      alert.remove();
      clearInterval(time);
    }, 3000);
  };

  /**
   * Inicializar cada evento
   */

  var events = function () {
    removeAlert();
    validationRegister();
    validationLogin();
    validationAddPet();
  };

  /**
   * Inicializar Todos los eventos
   */

  var init = function () {
    events();
  };

  /**
   * Inicializar los eventos cuando el DOM este cargado
   */

  window.addEventListener('DOMContentLoaded', function () {
    init();
  });
})();
