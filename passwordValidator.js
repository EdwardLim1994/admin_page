    //Toggle Visible Password Functions
    function toggleVisiblePassword(toggleID, inputID) {
        if ($(inputID).attr("type") === "password") {
            $(inputID).attr("type", "text");
            $(toggleID + " .fas").removeClass("fa-eye").addClass("fa-eye-slash");
        } else {
            $(inputID).attr("type", "password");
            $(toggleID + " .fas").removeClass("fa-eye-slash").addClass("fa-eye");
        }
    }

    //Not Valid Input function
    function notValidInput(inputID, validateID, text) {
        $(inputID).removeClass("is-valid").addClass("is-invalid");
        $(validateID).removeClass("valid-feedback").addClass("invalid-feedback").empty().html(text);
    }

    //Valid Input function
    function validInput(inputID, validateID) {
        $(inputID).removeClass("is-invalid").addClass("is-valid");
        $(validateID).removeClass("invalid-feedback").addClass("valid-feedback").empty().html("Looks good!");
    }

    function useOldPassword(inputID, validateID) {
        $(inputID).removeClass("is-invalid").addClass("is-valid");
        $(validateID).removeClass("invalid-feedback").addClass("valid-feedback").empty().html("Password will not change");
    }