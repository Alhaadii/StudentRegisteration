// Initial function to load data into the table
loadData();

// Variable to track the action (Insert or Update)
let btnAction = "Insert";

// Show the modal when 'Add New' button is clicked
$("#addNew").on("click", () => {
  $("#studentModal").modal("show");
});

// Handle form submission for Insert or Update
$("#stdForm").submit(function (event) {
  event.preventDefault();
  let form_data = new FormData($("#stdForm")[0]);
  if (btnAction == "Insert") {
    form_data.append("action", "create");
  } else {
    form_data.append("action", "updateStd");
  }

  $.ajax({
    url: "api.php",
    type: "POST",
    data: form_data,
    contentType: false,
    processData: false,
    success: function (response) {
      let status = response.status;
      let msg = response.data;
      $("#stdForm")[0].reset();
      $("#studentModal").modal("hide");
      alert(msg + " Status: " + status);
      btnAction = "Insert";
      loadData();
    },
    error: function (error) {
      console.log(error);
    },
  });
});

// Function to load data from the server and populate the table
function loadData() {
  $("#stdTable tbody").html("");
  let sendingData = { action: "readAll" };

  $.ajax({
    url: "api.php",
    type: "POST",
    datatype: "json",
    data: sendingData,
    success: function (response) {
      let status = response.status;
      let data = response.data;

      if (status) {
        let tr = "";
        data.forEach((item) => {
          tr += "<tr>";
          for (let i in item) {
            tr += `<td>${item[i]}</td>`;
          }
          tr += `<td>
                  <a class="btn btn-warning editBtn" update_id="${item["stdid"]}">Edit</a>
                  <a class="btn btn-danger deleteBtn" delete_id="${item["stdid"]}">Delete</a>
                </td>`;
          tr += "</tr>";
        });
        $("#stdTable tbody").append(tr);
      }
    },
    error: function (error) {
      console.log("know the load error");
      console.log(error);
    },
  });
}

// Function to fetch information of a specific student for editing
function fetchInfo(id) {
  let sendingData = { action: "readStudentInfo", id: id };
  console.log(sendingData.id);
  $.ajax({
    url: "api.php",
    type: "POST",
    datatype: "json",
    data: sendingData,
    success: function (response) {
      let status = response.status;
      let data = response.data;
      console.log(data);
      if (status) {
        $("#stdid").val(data[0].stdid);
        $("#stdname").val(data[0].stdname);
        $("#stdclass").val(data[0].stdclass);
        $("#studentModal").modal("show");
        btnAction = "Update";
        loadData();
        // $("#studentModal").modal("hide");
      }
    },
    error: function (error) {
      console.log("know the update error");
      console.log(error);
    },
  });
}

// Function to delete a specific student
function deleteInfo(id) {
  let sendingData = { action: "deleteStd", id: id };

  $.ajax({
    url: "api.php",
    type: "POST",
    datatype: "json",
    data: sendingData,
    success: function (response) {
      let status = response.status;
      let data = response.data;

      if (status) {
        loadData();
      }
    },
    error: function (error) {
      console.log("know the delete error");
      console.log(error);
    },
  });
}

// Event handler for editing a student
$("#stdTable").on("click", "a.editBtn", function () {
  let id = $(this).attr("update_id");
  // console.log(id);
  fetchInfo(id);
});

// Event handler for deleting a student
$("#stdTable").on("click", "a.deleteBtn", function () {
  let id = $(this).attr("delete_id");
  if (confirm("Are you sure you want to delete this: " + id + "?")) {
    deleteInfo(id);
  }
});
