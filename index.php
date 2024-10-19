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
                  src="assets/img/profile-img.jpg"
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
                    <form>
                      <div class="row mb-3">
                        <label
                          for="profileImage"
                          class="col-md-4 col-lg-3 col-form-label"
                          >Profile Image</label
                        >
                        <div class="col-md-8 col-lg-9">
                          <img src="assets/img/profile-img.jpg" alt="Profile" />
                          <div class="pt-2">
                            <a
                              href="#"
                              class="btn btn-primary btn-sm"
                              title="Upload new profile image"
                              ><i class="bi bi-upload"></i
                            ></a>
                            <a
                              href="#"
                              class="btn btn-danger btn-sm"
                              title="Remove my profile image"
                              ><i class="bi bi-trash"></i
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
                    <form>
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

<?php
require 'features/footer.php'; 
?>
