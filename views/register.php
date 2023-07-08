<h1>Register</h1>
<form action="" method="post">
  <div class="mb-3">
    <label for="firstname" class="form-label">First Name</label>
    <input type="text" name="firstname" class="form-control <?php echo $model->hasError('firstname') ? 'is-invalid' : '' ?> " id="firstname">
    <div class="invalid-feedback">
      <?php echo $model->getFirstError('firstname') ?>
    </div>
  </div>
  <div class="mb-3">
    <label for="lastname" class="form-label">Last Name</label>
    <input type="text" name="lastname" class="form-control" id="lastname">
  </div>
  <div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" name="email" class="form-control" id="email">
  </div>
  <div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" name="password" class="form-control" id="password">
  </div>
  <div class="mb-3">
    <label for="confirmPassword" class="form-label">Confirm Password</label>
    <input type="password" name="confirmPassword" class="form-control" id="confirmPassword">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>