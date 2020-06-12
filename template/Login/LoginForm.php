<div class="container">
    <h1>Login</h1>
    <h2>Enter your credentials below</h2>
    <?php if ($variables['status'] == 'fail'): ?>
    <div class="alert alert-danger">
        <strong>Fail!</strong> Mistake in login and/or password
    </div>
    <?php endif; ?>
    <form method="post" action="/login">
        <div class="form-group">
            <label for="login">Login</label>
            <input type="text" class="form-control" name="login" id="login" placeholder="Enter your login here" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" id="email" placeholder="Enter your password" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="/" class="btn btn-secondary">Go Home</a>
    </form>
</div>
