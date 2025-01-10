// Form validation module
const FormValidation = (() => {
    // Existing validation functions
  
    const validateRequired = (input) => {
      if (input.value.trim() === "") {
        setError(input, "This field is required");
        return false;
      } else {
        clearError(input);
        return true;
      }
    };
  
    const validateEmail = (input) => {
      const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
      if (!emailPattern.test(input.value.trim())) {
        setError(input, "Please enter a valid email");
        return false;
      } else {
        clearError(input);
        return true;
      }
    };
  
    const validatePassword = (input) => {
        const passwordPattern = /^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{6,}$/;
        const value = input.value.trim();
        
        if (!passwordPattern.test(value)) {
          setError(input, "Password must be at least 6 characters, contain 1 uppercase letter, 1 number, and 1 special character");
          return false;
        } else {
          clearError(input);
          return true;
        }
      };
    // New validation for the name field
    const validateName = (input) => {
      const namePattern = /^[A-Za-z][A-Za-z\s]*$/;
      const value = input.value.trim();
      if (!namePattern.test(value)) {
        if (/^\d/.test(value)) {
          setError(input, "Name cannot start with a number");
        }else if(value.length > 25) {
          setError(input, "Name cannot exceed more than 25 characters");
        } else {
          setError(input, "Name cannot contain special characters");
        } 
        return false;
      } else {
        clearError(input);
        return true;
      }
    };

  
    const setError = (input, message) => {
      const formControl = input.parentElement;
      const small = formControl.querySelector("small");
      small.innerText = message;
      formControl.classList.add("error");
    };
  
    const clearError = (input) => {
      const formControl = input.parentElement;
      const small = formControl.querySelector("small");
      small.innerText = "";
      formControl.classList.remove("error");
    };
  
    const validateField = (input) => {
      const type = input.getAttribute("data-validate");
      switch (type) {
        case "required":
          return validateRequired(input);
        case "email":
          return validateEmail(input);
        case "password":
          return validatePassword(input);
        case "name":
          return validateName(input); // New case for name validation
        case "nickname":
          return validateName(input);
        case "group-name":
          return validateName(input);
        case "role-name":
          return validateName(input);
        default:
          return true;
      }
    };
  
    const validateForm = (form) => {
      let isValid = true;
      const inputs = form.querySelectorAll("[data-validate]");
      inputs.forEach((input) => {
        if (!validateField(input)) {
          isValid = false;
        }
      });
      return isValid;
    };
  
    // Public API
    return {
      validateForm,
      validateField,
    };
  })();
  