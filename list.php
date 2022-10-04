<?php
    include 'DB.php';
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>게시판</title>

<link rel="stylesheet" type="text/css" href="css/all.css">
<link rel="stylesheet" type="text/css" href="css/list.css">

</head>
<body>

	<h1>목록</h1>
	<hr>
	
	<div id="all_body_div">
	<div id="SearchDiv">
		<form action="search.php" method="get" id="SearchDiv_inForm">&nbsp;
    		 제목 <input name="t">&nbsp;
    		 작성자 <input name="u">&nbsp;
    		 작성일 <input type="date" name="fd"> ~
    		 <input type="date" name="ld">&nbsp;
    		 <input type="submit" value="검색">&nbsp;
		 </form>
	</div>
	
		<?php 
		$paging = 10;
		$firstRownum = 0;
		$getpage =isset($_GET['page'])==false?"1":$_GET['page'];
		
		  $sql = "select bid, @rownum:=@rownum+1 rownum, count(@rownum) count 
                    from board board, (select @rownum:=0)r order by rownum";
		  $result = mysqli_query($conn, $sql);
		  $row = mysqli_fetch_array($result);
		  $count = $row['count'];
		  $totalpage = ceil($count/$paging);
		  
		  if(isset($_GET['page'])==TRUE){
		      for ($i = 0; $i < $totalpage+1; $i++) {
		          if ($getpage==$i) {
		              $firstRownum = (($_GET['page']-1) * $paging);
		          }
		      }
		  }
		?>
		
	<p id="listCount_Ptag">Total : <?=$count?> &nbsp;   page : <?=$getpage?>/<?=$totalpage?></p>	
	
<div id="table_div">
	<table id="listTable">
		<tr id="listTable_Title_tr">
			<th>제목</th>
			<th>구분</th>
			<th>제목</th>
			<th>첨부</th>
			<th>작성일</th>
			<th>작성자</th>
			<th>조회수</th>
		</tr>
		<?php 
		
		if(isset($_GET['page'])==false){
		    $sql="select @rownum:=@rownum+1 rownum, board.*
                from board board, (select @rownum:=0) r order by rownum
                limit ".$firstRownum.",".$paging;
		}
		
		$sql ="select @rownum:=@rownum+1 as rownum, board.*
                from board board, (select @rownum:=0) r order by rownum
                limit ".$firstRownum.",".$paging;
		
		$result = mysqli_query($conn, $sql);
		while($row = mysqli_fetch_array($result)){
		    $filter=array(
		        'rownum'=> htmlspecialchars($row['rownum']),
		        'bid'=> htmlspecialchars($row['bid']),
		        'boardtype'=> htmlspecialchars($row['boardtype']),
		        'title'=> htmlspecialchars($row['title']),
		        'realfilename'=> htmlspecialchars($row['realfilename']),
		        'writedate'=> htmlspecialchars($row['writedate']),
		        'username'=> htmlspecialchars($row['username']),
		        'hit'=> htmlspecialchars($row['hit'])
		    );
        ?>
		 <tr>
			<td><?=$filter['rownum']?></td>
			<td><?=$filter['boardtype']?></td>
			<td id="listTable_title_td"><a href='detail.php?no=<?=$filter['bid']?>'><?=$filter['title']?></a></td>
			<td><?=$filter['realfilename']!=NULL?'💾':''?></td>
			<td><?=$filter['writedate']?></td>
			<td><?=$filter['username']?></td>
			<td><?=$filter['hit']?></td>
		</tr>
		<?php } ?>
	</table>
</div>	
		<form>
    		<div id="paging">
			
			<a href='list.php' id='paging_a'> << </a>  &nbsp;
			<a href='list.php?page=<?=$getpage-1==0?1:$getpage-1?>' id='paging_a'> < </a> 	 &nbsp;	
    		<?php 
    		for ($i = 1; $i <= $totalpage; $i++) {
    		    echo "<a href='list.php?page=$i' id='paging_a'>".$i."</a> &nbsp";
    		}
    		?>
    		<a href='list.php?page=<?=$getpage+1 > $totalpage? $totalpage:$getpage+1?>' id='paging_a'> > </a>  &nbsp;	
    		<a href="list.php?page=<?=$totalpage?>" id='paging_a'> >> </a>
    		
    		</div>
		</form>
			
		<div id="listToWrite_Btn_div">
			<button id="btn_size" onclick="location.href='newWrite.php'">등록</button>
		</div>
		
	</div>
	
</body>
</html>


<?php 
    mysqli_close($conn);
?>