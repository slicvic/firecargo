<div class="alert alert-danger">
    <h4><i class="fa fa-times-circle"></i> Whoops! There was an error:</h4>
    <ul>
        <?php
            if (is_array($message)) {
                echo '<li>' . implode('</li><li>', $message) . '</li>';
            }
            else {
                echo '<li>' . $message . '</li>';
            }
        ?>
    </ul>
</div>
