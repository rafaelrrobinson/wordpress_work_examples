jQuery(document).ready(function ($) {
  loadUsers();

  $("#addUserForm").submit(function (event) {
    event.preventDefault();
    const username = $("#username").val();
    const password = $("#password").val();

    if (!validateEmail(username)) {
      alert("Invalid email address");
      return;
    }

    $.post(
      HtpasswdEditor.ajax_url,
      {
        action: "htpasswd_editor",
        action_type: "add",
        username: username,
        password: password,
        nonce: HtpasswdEditor.nonce,
      },
      function (response) {
        alert(response.data.message);
        loadUsers();
        $("#addUserForm")[0].reset();
      }
    );
  });

  $("#editUserForm").submit(function (event) {
    event.preventDefault();
    const username = $("#edit_username").val();
    const password = $("#edit_password").val();

    if (!validateEmail(username)) {
      alert("Invalid email address");
      return;
    }

    $.post(
      HtpasswdEditor.ajax_url,
      {
        action: "htpasswd_editor",
        action_type: "edit",
        username: username,
        password: password,
        nonce: HtpasswdEditor.nonce,
      },
      function (response) {
        alert(response.data.message);
        loadUsers();
        $("#editUserForm")[0].reset();
        $("#editUserForm").hide();
        $("#addUserForm").show();
      }
    );
  });

  function loadUsers() {
    $.post(
      HtpasswdEditor.ajax_url,
      {
        action: "htpasswd_editor",
        action_type: "list",
        nonce: HtpasswdEditor.nonce,
      },
      function (response) {
        if (response.success) {
          let userList =
            '<table class="wp-list-table widefat fixed striped table-view-list" id="flipbook-login-table"><thead><th>Username</th><th>Edit</th><th>Delete</th></thead><tbody>';
          response.data.users.forEach((user) => {
            userList += `<tr><td>${user}</td><td>
                                    <button onclick="editUser('${user}')" class="edit">Edit</button>
                                    </td><td>
                                    <button onclick="deleteUser('${user}')" class="delete">Delete</button>
                                 </td>`;
          });
          userList += "</tbody></table>";
          $("#userList").html(userList);
        }
      }
    );
  }

  window.editUser = function (username) {
    $("#edit_username").val(username);
    $("#addUserForm").hide();
    $("#editUserForm").show();
    $("html, body").animate({ scrollTop: 0 }, "slow");
  };

  window.deleteUser = function (username) {
    $.post(
      HtpasswdEditor.ajax_url,
      {
        action: "htpasswd_editor",
        action_type: "delete",
        username: username,
        nonce: HtpasswdEditor.nonce,
      },
      function (response) {
        alert(response.data.message);
        loadUsers();
      }
    );
  };

  function validateEmail(email) {
    const re = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    return re.test(email);
  }
});
