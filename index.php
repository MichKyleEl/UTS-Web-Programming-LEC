<?php
$pagename = "Profile"; // INI "Profile" CONTOH DOANK, NANTI KALIAN GANTI SENDIRI DENGAN NAMA PAGE YANG KALIAN BUAT 
$urlname = "index.php"; // INI "DASHBOARD" CONTOH DOANK, NANTI KALIAN GANTI SENDIRI DENGAN NAMA PAGE YANG KALIAN BUAT 
require 'database/config.php'; // config buat koneksi database doank
require 'authentication.php'; // authentication buat atur session, dll



require 'features/navbar.php';
require 'features/sidebar.php'; 
?>

<!-- main -->
<main id="main" class="main">

<?php
if (isset($_SESSION['alert'])) {
    $alertType = $_SESSION['alert']['type'];
    $alertMessage = $_SESSION['alert']['message'];
    
    echo '<div class="alert alert-' . $alertType . ' alert-dismissible fade show" role="alert">';
    echo '<i class="bi ' . ($alertType === 'success' ? 'bi-check-circle' : 'bi-exclamation-octagon') . ' me-1"></i>';
    echo htmlspecialchars($alertMessage);
    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
    echo '</div>';

    unset($_SESSION['alert']);
}

require 'features/pagetitle.php'; 
?>

<section class="section profile">
        <div class="row">
          <div class="col-xl-4">
            <div class="card">
              <div
                class="card-body profile-card pt-4 d-flex flex-column align-items-center"
              >
                <img
                  src="<?php echo ($foto == NULL) ? 'assets/img/profile-img.jpg' : 'uploads/profile/' . $foto; ?>"
                  alt="Profile"
                  class="rounded-circle"
                />
                <h2><?php echo htmlspecialchars($name); ?></h2>
                <h3><?php echo htmlspecialchars(ucfirst($role)); ?></h3>
              </div>
            </div>
          </div>

          <div class="col-xl-8">
            <div class="card">
              <div class="card-body pt-3">
                <!-- Bordered Tabs -->
                <ul class="nav nav-tabs nav-tabs-bordered">

                  <li class="nav-item">
                    <button
                      class="nav-link active"
                      data-bs-toggle="tab"
                      data-bs-target="#profile-edit"
                    >
                      Edit Profile
                    </button>
                  </li>

                  <li class="nav-item">
                    <button
                      class="nav-link"
                      data-bs-toggle="tab"
                      data-bs-target="#profile-change-password"
                    >
                      Change Password
                    </button>
                  </li>
                </ul>
                <div class="tab-content pt-2">
                  <div
                    class="tab-pane fade show active profile-edit pt-3"
                    id="profile-edit"
                  >
                    <!-- Profile Edit Form -->
                    <form action="updateprofile.php" METHOD="POST" enctype="multipart/form-data">
                      <div class="row mb-3">
                        <label
                          for="profileImage"
                          class="col-md-4 col-lg-3 col-form-label"
                          >Profile Image</label
                        >
                        <div class="col-md-8 col-lg-9">
                          <img id="profileImage" 
                          src="<?php echo ($foto == NULL) ? 'assets/img/profile-img.jpg' : 'uploads/profile/' . $foto; ?>" 
                          alt="Profile" 
                          style="max-width: 150px;max-height:150px">
                          <div class="pt-2">
                            <input type="hidden" name="hiddenID" value="<?php echo $id ?>">
                          <input type="file" id="fileUpload" name="foto" style="display: none;" onchange="handleFileChange(event)" />
                            <a
                              href="#"
                              class="btn btn-primary btn-sm"
                              title="Upload new profile image"
                              onclick="triggerFileUpload()"><i class="bi bi-upload"></i
                            ></a>
                          </div>
                        </div>
                      </div>

                      <div class="row mb-3">
                        <label
                          for="name"
                          class="col-md-4 col-lg-3 col-form-label"
                          >Full Name</label
                        >
                        <div class="col-md-8 col-lg-9">
                          <input
                            name="name"
                            type="text"
                            class="form-control"
                            id="name"
                            value="<?php echo htmlspecialchars($name); ?>"
                          />
                        </div>
                      </div>

                      <div class="row mb-3">
                        <label
                          for="email"
                          class="col-md-4 col-lg-3 col-form-label"
                          >email</label
                        >
                        <div class="col-md-8 col-lg-9">
                          <input
                            name="email"
                            type="email"
                            class="form-control"
                            id="email"
                            value="<?php echo htmlspecialchars($email); ?>"
                          />
                        </div>
                      </div>

                      <div class="text-center">
                        <button type="submit" class="btn btn-primary">
                          Save Changes
                        </button>
                      </div>
                    </form>
                    <!-- End Profile Edit Form -->
                  </div>

                  <div class="tab-pane fade pt-3" id="profile-change-password">
                    <!-- Change Password Form -->
                    <form action="updatepassword.php" METHOD="POST">
                      <div class="row mb-3">
                        <label
                          for="currentPassword"
                          class="col-md-4 col-lg-3 col-form-label"
                          >Current Password</label
                        >
                        <div class="col-md-8 col-lg-9">
                          <input
                            name="password"
                            type="password"
                            class="form-control"
                            id="currentPassword"
                          />
                        </div>
                      </div>

                      <div class="row mb-3">
                        <label
                          for="newPassword"
                          class="col-md-4 col-lg-3 col-form-label"
                          >New Password</label
                        >
                        <div class="col-md-8 col-lg-9">
                          <input
                            name="newpassword"
                            type="password"
                            class="form-control"
                            id="newPassword"
                          />
                        </div>
                      </div>


                      <div class="text-center">
                        <button type="submit" class="btn btn-primary">
                          Change Password
                        </button>
                      </div>
                    </form>
                    <!-- End Change Password Form -->
                  </div>
                </div>
                <!-- End Bordered Tabs -->
              </div>
            </div>
          </div>
        </div>
      </section>

</main>
<!-- end main -->

<!-- javascript buat handling edit file -->
 <script>

function triggerFileUpload() {
  document.getElementById('fileUpload').click();
}


function handleFileChange(event) {
  const file = event.target.files[0];
  
  if (file) {
    const reader = new FileReader();
    
    reader.onload = function(e) {
      document.getElementById('profileImage').src = e.target.result;
    };
    
    reader.readAsDataURL(file);
  }
}

 </script>
<?php
require 'features/footer.php'; 
?>
