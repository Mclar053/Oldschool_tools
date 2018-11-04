<div>
    <!-- Quest Details -->
    <div>
        <h1><?= $questDetails->NAME; ?></h1>
        <div>
            <?php
                if($questDetails->DESCRIPTION):
                    $questDetails->DESCRIPTION;
                else: ?>
                    No Description
            <?php endif; ?>
        </div>
        <div>
            <?= $questDetails->QUESTPOINTS ?> Quest Point<?php if($questDetails->QUESTPOINTS > 1): ?>s <?php endif; ?>
        </div>
        <div>
            <?= $questDetails->MEMBERSTEXT ?>
        </div>
    </div>
    <!-- Requirements -->
    <div>
        <!-- Skills -->
        <div>
            <div>Skills</div>
            <?php foreach($skillRequirements as $skill): ?>
                <div>
                    <?= $skill->SKILLNAME ?>: <?= $skill->LEVEL ?> 
                </div>
            <?php endforeach; ?>
            <?php if(sizeof($skillRequirements) === 0): ?>
                No Skill Requirements
            <?php endif; ?>
        </div>
        <!-- Quests -->
        <div>
        <div>Quests</div>
            <?php foreach($questRequirements as $quest): ?>
                <div>
                    <a href="index.php?page=quest&amp;id=<?= $quest->REQUIREDQUESTID ?>"><?= $quest->NAME ?></a>
                </div>
            <?php endforeach; ?>
            <?php if(sizeof($questRequirements) === 0): ?>
                No Quest Requirements
            <?php endif; ?>
        </div>
    </div>
    <!-- Rewards -->
    <div>
        <!-- Skill -->
        <div>
            <div>Skills</div>
            <?php foreach($skillRewards as $skill): ?>
                <div>
                    <?= $skill->SKILLNAME ?>: <?= $skill->XP ?> XP
                </div>
            <?php endforeach; ?>
            <?php if(sizeof($skillRewards) === 0): ?>
                No Skill Requirements
            <?php endif; ?>
        </div>
    </div>

</div>