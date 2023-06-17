<div class="img-ax">
    <img src="public/assets/dist/img/axelotl.png" alt="Ilustracja młodego axelotla">
</div>
<div class="title">
    <h1>AXOLOTL</h1>
</div>
<div class="welcome">
    <h2>RAZEM ZADAMY O NASZYCH PRZYJACIÓŁ</h2>
</div>
<?php flash('register'); ?>
<div class="form-group">
    <input type="text" required id="username" name="user[username]" placeholder="USERNAME" value="<?= $_SESSION['rrequest']['username']?>">
</div>

<div class="form-group">
    <input type="text" required id="user_password" name="user[user_password]" placeholder="PASSWORD" value="<?= $_SESSION['rrequest']['user_password']?>">
</div>

<div class="form-group">
    <label></label>
    <input type="submit" value="REGISTER" class="loginin">
</div>
