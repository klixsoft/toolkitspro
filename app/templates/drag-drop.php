<style>
.drag-area {
    padding: 2rem 0;
    border: 3px dashed rgb(var(--primaryrgb), 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    margin: 10px auto;
    cursor:pointer;
}

.drag-area .icon {
    font-size: 50px;
    color: var(--primary);
}

.drag-area .header {
    font-size: 20px;
    font-weight: 500;
    color: var(--primary);
}

.drag-area .support {
    font-size: 12px;
    color: gray;
    margin: 10px 0 15px 0;
}

.drag-area.active {
    border: 2px solid #1683ff;
}

.drag-area img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 15px;
}

.drag-area.dragging{
    background:rgb(var(--primaryrgb), 0.05);
}
</style>

<div class="drag-area">
    <div class="icon">
        <i class="<?php echo $icon; ?>"></i>
    </div>

    <span class="header"><?php echo $titles; ?></span>
    <input <?php echo $multiplefile; ?> type="file" <?php echo $multiplefile; ?> <?php echo $accepts; ?> class="imageFileUpload d-none" name="imageFileUpload" />
    <span class="support">Supports: <?php echo $supports; ?></span>
</div>