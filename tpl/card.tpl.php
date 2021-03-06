<!-- Un début de <div> existe de par la fonction dol_fiche_head() -->
	<input type="hidden" name="action" value="[view.action]" />
	<table width="100%" class="border">
        <colgroup>
            <col width="25%" class="labelColumn"/>
            <col width="75%" class="valueColumn"/>
        </colgroup>
		<tbody>
			<tr class="ref">
				<td>[langs.transnoentities(Ref)]
                    [onshow;block=begin;when [view.mode]='edit']
                    [view.refTooltip;htmlconv=no]
                    [onshow;block=end]
                </td>
				<td>[view.showRef;strconv=no]</td>
			</tr>

			<tr class="label">
				<td>[langs.transnoentities(Label)]
                    [onshow;block=begin;when [view.mode]='edit']
                    [view.labelTooltip;htmlconv=no]
                    [onshow;block=end]
                </td>
				<td>[view.showLabel;strconv=no]</td>
			</tr>
            <tr>
                <td>[langs.transnoentities(Price)]
                    [onshow;block=begin;when [view.mode]='edit']
                    [view.priceTooltip;htmlconv=no]
                    [onshow;block=end]
                </td>
                <td>[view.showPrice;strconv=no]</td>
            </tr>
            <tr>
                <td>[langs.transnoentities(Category)]
                [onshow;block=begin;when [view.mode]='edit']
                    [view.categoryTooltip;htmlconv=no]
                [onshow;block=end]
                </td>
                <td>[view.showCategory;strconv=no]</td>
            </tr>
            [onshow;block=begin;when [view.fk_product]+-0]
            [onshow;block=begin;when [view.mode]!='edit']
            <tr>
                <td>[langs.transnoentities(ProductRef)]</td>
                <td><a href="[view.productURL]">[view.productRefValue;htmlconv=no]</a></td>
            </tr>
            [onshow;block=end]
            [onshow;block=end]
		</tbody>
	</table>

</div> <!-- Fin div de la fonction dol_fiche_head() -->

[onshow;block=begin;when [view.mode]='edit']
<div class="center">
	
	<!-- '+-' est l'équivalent d'un signe '>' (TBS oblige) -->
	[onshow;block=begin;when [object.id]+-0]
	<input type='hidden' name='id' value='[object.id]' />
	[onshow;block=end]
    <input type="hidden" name="fk_product" value="[view.fk_product]" />
    <input type="submit" value="[langs.transnoentities(Save)]" class="button" />
	<input type="button" onclick="javascript:history.go(-1)" value="[langs.transnoentities(Cancel)]" class="button" formnovalidate />
	
</div>
[onshow;block=end]

[onshow;block=begin;when [view.mode]!='edit']
<div class="tabsAction">
	[onshow;block=begin;when [user.rights.citrusmanager2.write;noerr]=1]
			<div class="inline-block divButAction"><a href="[view.urlcard]?id=[object.id]&action=edit" class="butAction">[langs.transnoentities(Modify)]</a></div>
		<!-- '-+' est l'équivalent d'un signe '<' (TBS oblige) -->
			<div class="inline-block divButAction"><a href="[view.urlcard]?id=[object.id]&action=delete" class="butActionDelete">[langs.transnoentities(Delete)]</a></div>
	[onshow;block=end]
</div>
[onshow;block=end]