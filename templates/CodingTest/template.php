<div class="document">
    <?php echo $this->Document->names($plaintiffs, 5, 'Plaintiff') ?>
    <?php echo $this->Document->choice($plaintiffs, ' brings ', ' bring '); ?> this action seeking to enforce
    <?php echo $this->Document->choice($plaintiffs, 'Plaintiff’s', 'their'); ?>
    right to privacy under the consumer-privacy provisions of the Telephone Consumer Protection Act (“TCPA”), 47 U.S.C.
    § 227.

    <?php echo $this->Document->names($defendants, 5, 'Defendant') ?> violated the TCPA by using an automated dialing
    system, or “ATDS”, to send telemarketing text messages
    to <?php echo $this->Document->choice($plaintiffs, 'Plaintiff’s ', 'Plaintiffs’') ?>
    cellular telephone <?php echo $this->Document->choice($plaintiffs, 'number', 'numbers'); ?>
    for the purposes of advertising <?php echo $this->Document->choice($defendants, 'its', 'their'); ?>
    goods and services.

    <?php if ($dncrViolation): ?>
        Further violating the TCPA, <?php echo $this->Document->choice($defendants, 'Defendant', 'Defendants'); ?>
        sent multiple text messages to <?php echo $this->Document->choice($plaintiffs, 'Plaintiff', 'Plaintiffs'); ?>
        despite <?php echo $this->Document->choice($plaintiffs, ' Plaintiff’s ', 'their '); ?>
        presence on the National Do Not Call Registry<?php
        echo $idnclViolation ?
            ', and without maintaining <internal|italic> do not call procedures as required by law.'
            : '.'
        ?>
    <?php elseif (!$dncrViolation && $idnclViolation): ?>
        Further violating the TCPA, <?php echo $this->Document->choice($defendants, 'Defendant', 'Defendants'); ?>
        sent multiple text messages to <?php echo $this->Document->choice($defendants, 'Plaintiff', 'Plaintiffs'); ?>
        without maintaining internal do not call procedures as required by law.
    <?php endif; ?>

    <?php if ($tiaaViolation): ?>
        <?php echo ($dncrViolation || $idnclViolation) ? 'Lastly, ' : 'Also, ' ?>
        the text messages violated the Utah Truth In Advertising Act.
    <?php endif; ?>
</div>

