{include file="Files_external_header.tpl"}

<script src="modules/scribite/pnincludes/xinha/popups/popup.js" type="text/javascript"></script>
<script src="modules/Files/javascript/getFiles.js" type="text/javascript"></script>

<div class="files_container">
    <div class="z-clearfix">
        <div class="userpageicon">
            {img modname='core' src='lists.png' set='icons/large'}
        </div>
        <h2>{gt text="List of files in folder"} <strong>{$folderName}</strong></h2>
    </div>

    {insert name="getstatusmsg"}

    {if $notwriteable}
    <p class="z-errormsg">{gt text="It is not possible to write in this directory. Make it writable."}</p>
    {/if}

    <div class="actionIcons z-menuitem-title">
        <a class="fi_image fi_createdir" href="javascript: createDir('{$folderName}',1,{$hook})">{gt text="Create directory"}</a>
        <a class="fi_image fi_uploadfile" href="javascript: uploadFile('{$folderName}',1,{$hook})">{gt text="Upload file"}</a>
        {if $publicFolder}
        <a class="fi_image fi_public" href="{modurl modname='Files' type='user' func='setAsPublic' external='1' folder=$folderName|replace:'/':'|' hook=$hook not=1}">{gt text="Set as not public folder"}</a>
        {elseif $folderName neq ''}
        <a class="fi_image fi_notpublic" href="{modurl modname='Files' type='user' func='setAsPublic' external='1' folder=$folderName|replace:'/':'|' hook=$hook}">{gt text="Set as a public folder"}</a>
        {/if}
    </div>

    <div id="actionForm" class="actionForm">
        <div class="diskSpace">
            {gt text="Disk use:"}
            {if $usedSpace.maxDiskSpace neq -1048576}
            <div style="width:{$usedSpace.widthUsage}px; background:url(modules/Files/images/usage.gif);">&nbsp;</div>
            {gt text="%s%% - %s of %s" tag1=$usedSpace.percentage tag2=$usedSpace.usedDiskSpace tag3=$usedSpace.maxDiskSpace}
        </div>
        {else}
        <div class="diskSpace">{$usedSpace.usedDiskSpace}</div>
        {/if}
    </div>

    {if $publicFolder}
    <p class="z-informationmsg">
        {gt text="The files in this directory are accessible directly from the navigator. Anybody can access to them with the URL:"}
        <strong>{$baseurl}file.php?file={$folderPath}{if $folderPath|substr:-1 neq '/'}/{/if}{gt text="file_name"}</strong>
    </p>
    {/if}

    <form class="z-form" method="post" action="{modurl modname='Files' type='user' func='actionSelect' folder=$folderName|replace:'/':'|' hook=$hook}"  id="form1">
        <div>
            <input type="hidden" name="external" value="1" />
            <table class="z-datatable" summary="table files">
                <thead>
                    <tr>
                        <th align="center"></th>
                        <th>{gt text="Name"}</th>
                        <th>{gt text="Size"}</th>
                        <th>{gt text="Modified"}</th>
                        <th>{gt text="Action"}</th>
                    </tr>
                </thead>
                <tbody>
                    {if $folderName neq ""}
                    <tr class="{cycle values="z-odd,z-even"}">
                        <td>&nbsp;</td>
                         <td>
                             <a class="fi_image fi_folder" href="{modurl modname='Files' type='external' func='getFiles' hook=$hook folder=''}">
                                 .
                             </a>
                         </td>
                         <td>&nbsp;</td>
                         <td>&nbsp;</td>
                         <td>&nbsp;</td>
                     </tr>
                     <tr class="{cycle values="z-odd,z-even"}">
                         <td>&nbsp;</td>
                         <td>
                             <a class="fi_image fi_folder" href="{modurl modname='Files' type='external' func='getFiles' hook=$hook folder=$folderPrev}">
                                 ..
                             </a>
                         </td>
                         <td>&nbsp;</td>
                         <td>&nbsp;</td>
                         <td>&nbsp;</td>
                     </tr>
                     {/if}

                     {foreach item=file from=$fileList.dir}
                     {if $file.name neq '.tbn'}
                     <tr class="{cycle values="z-odd,z-even"}">
                         <td align="center">
                             <input type="checkbox" name="list_{$file.name|replace:'.':'$$$$$'}" onclick="stateCheckAll(this.checked)" />
                         </td>
                         <td align="left">
                             {if $folderName eq ''}
                             <a class="fi_image fi_folder" href="{modurl modname='Files' type='user' func='getFiles' type='external' hook=$hook folder=$file.name}">
                                 {$file.name}
                             </a>
                             {else}
                             <a class="fi_image fi_folder" href="{modurl modname='Files' type='user' func='getFiles' type='external' hook=$hook folder=$folderName|cat:'/'|cat:$file.name}">
                                 {$file.name}
                             </a>
                             {/if}
                         </td>
                         <td>&nbsp;</td>
                         <td align="right">{$file.time|dateformat:'datetimebrief'}</td>
                         <td align="right">
                             <a href="{modurl modname='Files' type='user' external='1' func='action' do='rename' fileName=$file.name folder=$folderName|replace:'/':'|' hook=$hook}">
                                 {img modname='core' src='edit.png' set='icons/extrasmall' __alt="Rename file" __title="Rename folder"}
                             </a>
                             <a href="{modurl modname='Files' type='user' external='1' func='action' do='delete' fileName=$file.name folder=$folderName|replace:'/':'|' hook=$hook}">
                                 {img modname='core' src='14_layer_deletelayer.png' set='icons/extrasmall' __alt="Delete folder" __title="Delete folder"}
                             </a>
                         </td>
                     </tr>
                     {/if}
                     {/foreach}

                     {foreach item=file from=$fileList.file}
                     {if $file.name|substr:0:1 neq '.'}
                     <tr class="{cycle values="z-odd,z-even"}">
                         <td align="center">
                             <input type="checkbox" name="list_{$file.name|replace:'.':'$$$$$'}" onclick="stateCheckAll(this.checked)" />
                         </td>
                         <td align="left">
                             {if $publicFolder}
                             {if $hook eq 1}
                             <a class="fi_image" style="background: url({$baseurl}modules/Files/images/fileIcons/{$file.fileIcon}) no-repeat 0 50%;" href="{modurl modname='Files' type='user' func='downloadFile' folder=$folderName|replace:'/':'|' fileName=$file.name hook=$hook}">
                                 {$file.name}
                             </a>
                             {else}
                             <a class="fi_image" style="background: url({$baseurl}modules/Files/images/fileIcons/{$file.fileIcon}) no-repeat 0 50%;">
                                 {$file.name}
                             </a>
                             {/if}
                             {else}
                             {$file.name}
                             {/if}
                         </td>
                         <td align="right">
                             {$file.size} {gt text="Bytes"}
                         </td>
                         <td align="right">
                             {$file.time|dateformat:'datetimebrief'}
                         </td>
                         <td align="right">
                             {foreach item=option from=$file.options}
                             <a href="{$option.url|safetext}">
                                 {img modname=core set=icons/extrasmall src=$option.image title=$option.title alt=$option.title}
                             </a>
                             {/foreach}
                         </td>
                     </tr>
                     {/if}
                     {/foreach}
                    </tbody>
                </table>

                <fieldset>
                    <select id="menuaction" name="menuaction" onchange="javascript:getElementById('form1').submit()">
                        <option value="">{gt text="-- Selected files --"}</option>
                        <option value="move">{gt text="Move them to another folder"}</option>
                        <option value="delete">{gt text="Delete them"}</option>
                        <option value="zip">{gt text="Create a zip file with them"}</option>
                    </select>
                </fieldset>
            </div>
        </form>

        {if $publicFolder AND  $imagesArray|count gt 0}
        {foreach item=file from=$imagesArray}
        {include file="Files_external_getFilesImgContent.tpl"}
        {/foreach}
        <div style="clear: both;"></div>
        <div class="z-informationmsg">
            {gt text="The values displayed in each image are its real size \"width x height\" and the factor of the modification of its size (value). The value 1 means that the image is in its natural size. A value upper than 1 means that the image has been reduced and a value lower than 1 means that the image has been increased."}
        </div>
        {/if}
    </div>

    {include file="Files_external_footer.tpl"}