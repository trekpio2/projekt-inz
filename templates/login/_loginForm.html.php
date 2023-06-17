<div class="img-ax">
    <img src="public/assets/dist/img/axelotl.png" alt="Ilustracja młodego axelotla">
</div>
<div class="title">
    <h1>AXOLOTL</h1>
</div>
<div class="welcome">
    <h2>RAZEM ZADAMY O NASZYCH PRZYJACIÓŁ</h2>
</div>
<?php flash('login'); ?>
<div class="form-group">
    <input type="text" required id="username" name="user[username]" placeholder="USERNAME" value="<?= $_SESSION['lrequest']['username']?>">
</div>

<div class="form-group">
    <input type="password" required id="user_password" name="user[user_password]" placeholder="PASSWORD" value="<?= $_SESSION['lrequest']['user_password']?>">
</div>

<div class="form-group">
    <label></label>
    <input type="submit" value="LOG IN" class='loginin'>
</div>
