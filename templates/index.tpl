{ft_include file='modules_header.tpl'}

  <table cellpadding="0" cellspacing="0">
  <tr>
    <td width="45"><a href="index.php"><img src="images/icon.png" border="0" width="34" height="34" /></a></td>
    <td class="title">
      <a href="../../admin/modules">{$LANG.word_modules}</a>
      <span class="joiner">&raquo;</span>
      {$L.module_name}
    </td>
  </tr>
  </table>

  {ft_include file="messages.tpl"}

  {if $num_results == 0}
    <div class="notify margin_bottom_large">
      <div style="padding: 6px">
        No errors reported. Booyah!
      </div>
    </div>
  {else}
    {$pagination}

    <form action="{$same_page}" method="post">
	    <table class="list_table" width="100%">
	    <tr>
	      <th width="140">Time</th>
	      <th>Line</th>
	      <th>URL</th>
	      <th>Message</th>
	    </tr>
	    {foreach from=$lines item=line name=row}
	      <tr>
	        <td>{$line.error_datetime}</td>
	        <td>{$line.line}</td>
	        <td>{$line.url}</td>
	        <td>{$line.msg}</td>
	      </tr>
	    {/foreach}
	    </table>

	    <p>
	      <input type="submit" name="clear" value="Clear Logs" />
	    </p>
	  </form>
  {/if}

{ft_include file='modules_footer.tpl'}
