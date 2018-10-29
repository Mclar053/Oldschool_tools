<div>
    <!-- Quest Details -->
    <div>
        <h1><?= $questDetails->NAME; ?></h1>
        <div>
            <?php
                if($questDetails->DESCRIPTION) {
                    $questDetails->DESCRIPTION;
                } 
                else { ?>
                    No Description
                <?php } ?>
        </div>
        <div>
            <?= $questDetails->QUESTPOINTS ?> Quest Point(s)
        </div>
        <div>
            <?php if($questDetails->MEMBERS == 1) { ?> Members
            <?php } else { ?> Free to play <?php } ?>
        </div>
    </div>
    <!-- Requirements -->
    <div>

    </div>
    <!-- Rewards -->
    <div>

    </div>

</div>