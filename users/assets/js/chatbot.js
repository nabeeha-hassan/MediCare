// Wait until page fully loads
document.addEventListener("DOMContentLoaded", function () {

    const chatIcon = document.getElementById("chat-icon");
    const chatBox = document.getElementById("chatbot-container");
    const closeBtn = document.getElementById("close-chat");
    const userInput = document.getElementById("userInput");
    const chatArea = document.getElementById("chatbox");

    // Open chat
    chatIcon.addEventListener("click", function () {
        chatBox.style.display = "block";
    });

    // Close chat
    closeBtn.addEventListener("click", function () {
        chatBox.style.display = "none";
    });

    // Chat logic
    userInput.addEventListener("keypress", function (e) {
        if (e.key === "Enter") {

        let input = this.value.toLowerCase();
        let response = "";

        // Greeting
        if (input.includes("hello") || input.includes("hi")) {
            response = "Hello 👋 Welcome to MediCare! How can I assist you today?";
        }

        // Complaint related
        else if (input.includes("complaint")) {
            response = "You can register a complaint from the 'Lodge Complaint' section in your dashboard.";
        }

        else if (input.includes("register complaint")) {
            response = "Click on 'Lodge Complaint' in the menu and fill in the required details.";
        }

        else if (input.includes("complaint status")) {
            response = "You can check your complaint status in the 'Complaint History' section.";
        }

        else if (input.includes("track complaint")) {
            response = "Go to 'Complaint History' to track all your complaints.";
        }

        else if (input.includes("edit complaint")) {
            response = "Currently, editing complaints is not allowed. You may contact admin.";
        }

        else if (input.includes("delete complaint")) {
            response = "Complaint deletion is restricted. Please contact admin if needed.";
        }

        // Status related
        else if (input.includes("pending")) {
            response = "Pending complaints are those not yet processed by the admin.";
        }

        else if (input.includes("in process")) {
            response = "Complaints marked 'In Process' are currently being handled.";
        }

        else if (input.includes("closed")) {
            response = "Closed complaints have been successfully resolved.";
        }

        // Account related
        else if (input.includes("login")) {
            response = "Use your registered email and password to login.";
        }

        else if (input.includes("logout")) {
            response = "Click on the logout button in the top menu.";
        }

        else if (input.includes("password")) {
            response = "You can change your password from the 'Account Settings'.";
        }

        else if (input.includes("forgot password")) {
            response = "Please contact admin to reset your password.";
        }

        // Notifications
        else if (input.includes("email")) {
            response = "You will receive email notifications when your complaint status is updated.";
        }

        else if (input.includes("notification")) {
            response = "Notifications appear when your complaint status changes.";
        }

        // System related
        else if (input.includes("admin")) {
            response = "Admin manages complaints and updates their status.";
        }

        else if (input.includes("dashboard")) {
            response = "Dashboard shows summary of your complaints and their status.";
        }

        else if (input.includes("profile")) {
            response = "You can view your profile details in the 'Account Setting' section.";
        }

        else if (input.includes("help")) {
            response = "I can help you with complaints, status, login, and more!";
        }

        else if (input.includes("contact")) {
            response = "For further help, please contact the admin.";
        }

        else if (input.includes("thanks") || input.includes("thank you")) {
            response = "You're welcome 😊 Happy to help!";
        }

        else if (input.includes("who are you")) {
            response = "I am MediCare Assistant 🤖, here to help you with your queries.";
        }

        // Default fallback
        else {
            response = "Sorry, I didn't understand that. Try asking about complaints, status, login, or help.";
        }

            chatArea.innerHTML += 
                "<p><b>You:</b> " + input + "</p>" +
                "<p><b>Bot:</b> " + response + "</p>";

            userInput.value = "";
        }
    });

});
