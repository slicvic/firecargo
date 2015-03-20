<div class="alert alert-danger">
    <i class="fa fa-times-circle"></i>
    <?php
        if (is_string($message))
        {
            echo $message;
        }
        else
        {
            echo '<ul>';

            if (is_array($message))
            {
                foreach($message as $error)
                {
                    echo '<li>' . $error . '</li>';
                }
            }
            elseif ($message instanceof Illuminate\Support\MessageBag)
            {
                foreach($message->getMessages() as $errors)
                {
                    foreach($errors as $error)
                    {
                        echo '<li>' . $error . '</li>';
                    }
                }
            }

            echo '</ul>';
        }
    ?>
</div>
