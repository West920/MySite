
							</div>
							<div class="col-md-2"><div class="border side-left">Сайд бар справа</div></div>
        </div>
    </div>
</div>
</div>
<? 
$bench->end(); 
echo 'Время выполнения скрипта = '.$bench->getTime().'<br>'; // 156ms or 1.123s
echo 'Используемая память = '.$bench->getMemoryPeak().'<br>'; // 152B or 90.00Kb or 15.23Mb

?>
</body>
</html>