{insert name="getstatusmsg"}
<h2>{gt text="Files module installation"}</h2>

{if $step eq 'info'}
<h3>{gt text="Welcome to Files module"}</h3>
<p class="z-informationmsg">
    {gt text="This module allow user to manage their own files.<br />Each user has a folder for his/her files.<br />This module needs two writable folders that have to be created."}
</p>
<p class="z-center">
    <a href="{modurl modname='Files' type='interactiveinstaller' func='form'}">{gt text="Proceed with the installation"}
    </a>
</p>

{elseif $step eq 'form'}
<p class="z-informationmsg">
    {gt text="Check if the files folders in the server have been created and define them using the form below.<br />These folders will be used to save the files of the site and the users' files.<br />We recommend to locate them out of the public HTTP."}
</p>

<form class="z-form" method="post" action="{modurl modname='Files' type='interactiveinstaller' func='update'}">
    <fieldset>
        <legend>{gt text="Defining the files folders"}</legend>
        <div class="z-formrow">
            {if not $createdFilesFolder}
            <label for="filesRealPath">{gt text="Write the physical location of the folder in the server"}</label>
            <input type="text" id="filesRealPath" name="filesRealPath" size="30" maxlength="50" value="{$filesRealPath}" />
            {/if}
        </div>
        <div class="z-formrow">
            <label for="filesRealPath">{gt text="Write the users' folder name"}</label>
            <div>
                {if not $createdFilesFolder}{$filesRealPath}/{/if}
                <input type="text" name="usersFolder" size="30" maxlength="50" value="{$usersFolder}" />
            </div>
        </div>
    </fieldset>
    <div class="z-formbuttons">
        <input type="submit" value="{gt text='Accept'}" />
    </div>
</form>
{elseif $step eq 'check'}
<h3>
    {gt text="Checking if the files folders exist and they are writable"}
</h3>
<ul>
    {if not $multisites}
    {if !$file1}
    <li>
        {img modname='core' src='error.png' set='icons/extrasmall'}
        {gt text="The folder <strong>%s</strong> has not been found." tag1=$filesRealPath}
    </li>
    {else}
    <li>
        {img modname='core' src='button_ok.png' set='icons/extrasmall'}
        {gt text="The folder <strong>%s</strong> is located in the correct place." tag1=$filesRealPath}
    </li>
    {if !$fileWriteable1}
    <li>
        {img modname='core' src='error.png' set='icons/extrasmall'}
        {gt text="The folder <strong>%s</strong> is not writable and it should be." tag1=$filesRealPath}
    </li>
    {else}
    <li>
        {img modname='core' src='button_ok.png' set='icons/extrasmall'}
        {gt text="The folder <strong>%s</strong> is writable." tag1=$filesRealPath}
    </li>
    {/if}
    {/if}
    {/if}
    {if !$file2}
    <li>
        {img modname='core' src='error.png' set='icons/extrasmall'}
        {gt text="The folder <strong>%s/%s</strong> has not been found." tag1=$filesRealPath tag2=$usersFolder}
    </li>
    {else}
    <li>
        {img modname='core' src='button_ok.png' set='icons/extrasmall'}
        {if not $multisites}
        {gt text="The folder <strong>%s/%s</strong> is located in the correct place." tag1=$filesRealPath tag2=$usersFolder}
        {else}
        {gt text="The folder <strong>%s</strong> is located in the correct place." tag1=$usersFolder}
        {/if}
    </li>
    {if !$fileWriteable2}
    <li>
        {img modname='core' src='error.png' set='icons/extrasmall'}
        {if not $multisites}
        {gt text="The folder <strong>%s/%s</strong> is not writable and it should be." tag1=$filesRealPath tag2=$usersFolder}
        {else}
        {gt text="The folder <strong>%s</strong> is not writable and it should be." tag1=$usersFolder}
        {/if}
    </li>
    {else}
    <li>
        {img modname='core' src='button_ok.png' set='icons/extrasmall'}
        {if not $multisites}
        {gt text="The folder <strong>%s/%s</strong> is writable." tag1=$filesRealPath tag2=$usersFolder}
        {else}
        {gt text="The folder <strong>%s</strong> is writable." tag1=$usersFolder}
        {/if}
    </li>
    {/if}
    {/if}
</ul>

<div class="z-center">
    {if !$file1 OR !$file2}
    <a href="{modurl modname='Files' type='interactiveinstaller' func='form' file1=$filesRealPath file2=$usersFolder}">
        {gt text="Define folders again. Remember that you have to create the folders after define them."}
    </a>
    {/if}
    {if (!$fileWriteable1 OR !$fileWriteable2) AND NOT (!$file1 OR !$file2)}
    <a href="{modurl modname='Files' type='interactiveinstaller' func='form' file1=$filesRealPath file2=$usersFolder}">
        {gt text="Make the folders writable and try again."}
    </a>
    {/if}

    {if $fileWriteable1 AND $fileWriteable2}
    <form class="z-form" action="{modurl modname='Extensions' type='admin' func='initialise'}" method="post" enctype="application/x-www-form-urlencoded">
        <div>
            <input type="hidden" name="csrftoken" value="{insert name='csrftoken'}" />
            <input type="hidden" name="activate" value="1" />
            <div class="z-formbuttons">
                <input name="submit" type="submit" value="{gt text='Proceed with the module installation'}" />
            </div>
        </div>
    </form>
    {/if}
</div>
{/if}