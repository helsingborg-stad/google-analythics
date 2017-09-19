<div class="wrap">
    <h1><?php _e('Google Analytics settings', 'google-analytics' ); ?></h1>

    <?php echo $notice; ?>

    <?php if ($service_key == false): ?>
        <div class="service-account">
        <p><?php _e('To track and display statistics from Google Analytics you need to connect a Service Account with read abilities to the desired property. <br>Enter the contents from your Service Accounts private key JSON-file below.', 'google-analytics' ); ?></p>
            <form method="post" id="save-service-account" action="/wp-admin/admin-ajax.php">
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="service_account_key"><?php _e('Private key', 'google-analytics' )?></label>
                        </th>
                        <td>
                            <textarea name="service_account_key" rows="6" cols="60" /></textarea>
                        </td>
                    </tr>
                </table>
                <p class="submit">
                    <input name='submit' type='submit' class='button-primary' value='<?php _e('Save', 'google-analytics') ?>' />
                </p>
            </form>
        </div>
    <?php else: ?>
        <div class="analytics-property">
        <h3><?php _e('Select property', 'google-analytics'); ?></h3>
        <p><?php _e('Select the property you wish to track with Google Analytics.', 'google-analytics' ); ?></p>
            <form method="post" id="analytics-property">
                <?php wp_nonce_field('save', 'save-tracked-property'); ?>
                <select name="track_property">
                    <option value=""><?php _e('Select property', 'google-analytics') ?></option>
                    <?php
                        foreach ($properties as $property) {
                            $selected = ($tracked_property == $property['id']) ? 'selected' : '';
                            echo "<option value='" . json_encode($property) . "' " . $selected . " >" . $property['name'] . " – " . $property['id'] . "</option>";
                        }
                    ?>
                </select>
                <p class="submit">
                    <input name='submit' type='submit' class='button-primary' value='<?php _e('Save', 'google-analytics');  ?>' />
                    <input name='reset_credentials' type='submit' class='button' value='<?php _e('Reset credentials', 'google-analytics');  ?>' />
                </p>
            </form>
        </div>
    <?php endif ?>
</div>
