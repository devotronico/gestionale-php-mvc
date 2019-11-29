<section class="pagination">
  <ul class="pagination-list">
    <?php  $pageLast=ceil($totalPosts / $postForPage);?>
    <?php if( $currentPage > 1 ) : ?>
      <li class="page__item -first"><a class="page__link -active" href="/blog/page/<?=1?>/">&#9664;&#9664;</a></li>
      <li class="page__item"><a class="page__link -active" href="/blog/page/<?=$currentPage-1?>/">&#9664;</a></li>
    <?php else : ?>
      <li class="page__item -first"><a class="page__link -disabled" tabindex="-1">&#9664;&#9664;</a></li>
      <li class="page__item"><a class="page__link -disabled" tabindex="-1">&#9664;</a></li>
    <?php endif; ?>
    <?php for ( $pageNum=$currentPage-$postForPage; $pageNum<=$pageLast; $pageNum++ ) : ?>
      <?php if ( $pageNum>0 ) : ?>
        <?php if ( $pageNum <= $currentPage + $postForPage && $pageNum >= $currentPage - $postForPage) : ?>
          <?php if( $pageNum==$currentPage ) : ?>
            <li class="page__item"><a class="page__link -current"><?=$pageNum?></a></li>
          <?php elseif ( $pageNum == $currentPage +  $postForPage ) : ?>
            <li class="page__item -dots"><a class="page__link -active" href="/blog/page/<?=$pageNum?>/">...</a></li>
          <?php elseif ( $pageNum == $currentPage -  $postForPage) : ?>
            <li class="page__item -dots"><a class="page__link -active" href="/blog/page/<?=$pageNum?>/">...</a></li>
          <?php else : ?>
            <li class="page__item -number"><a class="page__link -active" href="/blog/page/<?=$pageNum?>/"><?=$pageNum?></a></li>
          <?php endif; ?>
        <?php endif; ?>
      <?php endif; ?>
    <?php endfor; ?>
    <?php if( $currentPage != $pageLast) : ?>
      <li class="page__item"><a class="page__link -active" href="/blog/page/<?=$currentPage+1?>/">&#9654;</a></li>
      <li class="page__item -last"><a class="page__link -active" href="/blog/page/<?=$pageLast?>/">&#9654;&#9654;</a></li>
    <?php else : ?>
      <li class="page__item"><a class="page__link -disabled" tabindex="+1">&#9654;</a></li>
      <li class="page__item -last"><a class="page__link -disabled" tabindex="+1">&#9654;&#9654;</a></li>
    <?php endif; ?>
  </ul>
</section>

