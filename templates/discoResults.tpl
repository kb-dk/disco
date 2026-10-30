{**
* templates/discoResults.tpl
*
* Copyright (c) 2014-2020 Simon Fraser University
* Copyright (c) 2003-2020 John Willinsky
* Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
*
* TODO text.
*}
<form class="pkp_form">
    <h3>{translate key="plugins.generic.disco.results"}</h3>
    <p>{translate key="plugins.generic.disco.results.description"}</p>

    {foreach from=$resultsKnowledgeBase key=service item=results}
        <h3>{$results.name}</h3>   
        <div>

            {if array_key_exists("count", $results) && $results["count"]}
                <div class ="results_score" íd="results_score_{$service}"><strong>{translate key="plugins.generic.disco.score"}:</strong> {$results["score"]}/{$results["count"]}</div>
            {/if}
            {if array_key_exists("application", $results) && $results["application"] && $results["score"] == $results["count"]}
                <div class ="results_application" íd="results_application_{$service}">
                    <a href="{$results.application}" target="_blank" class="pkpBadge pkpBadge--button pkpBadge--submission"> {translate key="plugins.generic.disco.knowledgeBase.{$service}.application"}</a>
                </div>
            {/if}
        </div>
        <div class="info-block">
            <a href="javascript:void(0);" class="toggle-btn" data-target="info_{$service}">
                <span class="arrow">&#9654;</span> <!-- Šipka doprava -->
                <span class="toggle-text">More information</span>
            </a>
            <div id="info_{$service}" class="info-content" style="display: none;">
                {if array_key_exists("requirements", $results)}
                    <h3>{translate key="plugins.generic.disco.requirements"}</h3>
                    <ul>
                        {foreach from=$results["requirements"] item=requirement}                            
                            <li class="results_requiremens {if empty($results["fulfilledCriteria"]) || !in_array($requirement, $results["fulfilledCriteria"])}not_fulfilled{/if}">{translate key="plugins.generic.disco.{$requirementsCategory[$requirement]}.{$requirement}"} ({translate key="plugins.generic.disco.{$requirementsCategory[$requirement]}"})</li>
                            
                            {foreach from=$results["autocheckedCriteria"][$requirement] key=autoCheck item=value}      
                                <li class="results_requiremens {if !$value}not_fulfilled{/if}">{translate key="plugins.generic.disco.{$autoCheck}.autocheck"}</li>

                            {/foreach}
                        {/foreach}
                    </ul>
                {/if}
                <h3>{translate key="plugins.generic.disco.serviceDescription"}</h3>
                {translate key="plugins.generic.disco.knowledgeBase.{$service}.description"}
            </div>
        </div>
    {/foreach}
</form>
