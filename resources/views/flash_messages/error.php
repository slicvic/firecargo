<div class="alert alert-danger">
    <i class="fa fa-times-circle"></i> The following error(s) occurred:
    <ul>
    <?php
        if (is_string($message))
        {
            echo '<li>' . $message . '</li>';
        }
        elseif (is_array($message))
        {
            foreach($message as $error)
            {
                echo '<li>' . $error . '</li>';
            }
        }
        elseif ($message instanceof \Illuminate\Validation\Validator)
        {
            foreach ($message->messages()->getMessages() as $errors)
            {
                foreach ($errors as $error)
                {
                    echo '<li>' . $error . '</li>';
                }
            }
        }
    ?>
    </ul>
</div>
