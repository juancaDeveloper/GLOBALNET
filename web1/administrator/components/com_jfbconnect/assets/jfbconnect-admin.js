/**
 * @package         JFBConnect
 * @copyright (c)   2009-2020 by SourceCoast - All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @version         Release v8.4.4
 * @build-date      2020/07/24
 */
if (typeof jfbcJQuery == "undefined")
    jfbcJQuery = jQuery;

var jfbcAdmin = {
    ajax: function (url, callback)
    {
        jfbcJQuery.ajax({url: 'index.php',
            data: url}
        ).done(callback);
    },

    autotune: {
        enablePlugin: function (name, status)
        {
            form = document.getElementById('adminForm');
            form.pluginName.value = name;
            form.pluginStatus.value = status;
            form.task.value = 'publishPlugin';
            form.submit();
        },
        fetchNetworkSettings: function()
        {
            jfbcAdmin.ajax('option=com_jfbconnect&controller=autotune&task=fetchNetworkSettings', jfbcAdmin.autotune.updateNetworkSettings)
        },
        updateNetworkSettings: function(responseJson)
        {
            var response = JSON.parse(responseJson);
            jfbcJQuery('#autotune-network-settings-status').html(response.message);

            if (response.success)
            {
                jfbcJQuery('.networksettings-updatedate').html(response.date);
            }
        }
    },

    scsocialwidget: {
        fetchWidgets: function (name)
        {
            jfbcAdmin.ajax('option=com_jfbconnect&controller=ajax&task=scsocialprovider&provider=' + name + '&id=' + sc_modid, jfbcAdmin.scsocialwidget.showWidgets);
        },

        showWidgets: function (ret)
        {
            jfbcJQuery('#widget_settings').html("");
            jfbcJQuery('#widget_list').html("");

            var $response = jQuery(ret).clone();//we clone using jQuery namespace so we can use chosen()
            $response.appendTo('#widget_list');
            $response.chosen();

            jfbcJQuery("jform[params][widget_type]").val("widget");
        },

        fetchSettings: function (name)
        {
            if (name == 'widget')
                jfbcJQuery('#widget_settings').html("");
            else
            {
                var provider = jfbcJQuery("#jform_params_provider_type").val();
                jfbcAdmin.ajax('option=com_jfbconnect&controller=ajax&task=scsocialwidget&provider=' + provider + '&name=' + name + '&id=' + sc_modid, jfbcAdmin.scsocialwidget.showSettings);
            }
        },

        showSettings: function (ret)
        {
            jfbcJQuery('#widget_settings').html(ret);
            jQuery("#widget_settings select").chosen();
            jfbcMakePrettyRadioButtons();

            //trigger bootstrap tooltip
            jQuery("#widget_settings .hasTooltip").tooltip({"html": true,"container": "body"});
        }
    },

    channels: {
        outbound: {
            fetchChannels: function (name)
            {
                jfbcJQuery('#channel-attribs').html('<div class="jfbc-error">' + jfbc_language_select_provider + '</div>');
                if (name != '--')
                    jfbcAdmin.ajax('option=com_jfbconnect&controller=ajax&task=channelGetOutboundChannels&provider=' + name, jfbcAdmin.channels.outbound.showChannels);
            },
            showChannels: function (ret)
            {
                jfbcJQuery('#channel-attribs').html('<div class="jfbc-error">' + jfbc_language_select_provider + '</div>');
                jfbcJQuery('#jform_type').parent().html(ret);
            },
            fetchChannelSettings: function (name)
            {
                var provider = jfbcJQuery("#jform_provider").val();
                jfbcAdmin.ajax('option=com_jfbconnect&controller=ajax&task=channelGetOutboundChannelSettings&provider=' + provider + '&channel=' + name, jfbcAdmin.channels.outbound.showSettings);
            },
            showSettings: function (ret)
            {
                var provider = jfbcJQuery("#jform_provider").val();
                var type = jfbcJQuery("#jform_type").val();

                if(type == "--" || provider == "--")
                {
                    jfbcAdmin.ajax('option=com_jfbconnect&controller=ajax&task=channelGetOutboundChannelSettings&provider=' + provider + '&channel=' + name, jfbcAdmin.channels.outbound.showSetupMessage);
                }
                else
                {
                    jfbcAdmin.ajax('option=com_jfbconnect&controller=ajax&task=channelShowAttributes&provider='+provider+'&type='+type, jfbcAdmin.channels.outbound.showAttribs);
                }
            },
            showAttribs: function (ret)
            {
                jfbcJQuery('#channel-attribs').html(ret);

                jfbcJQuery(function($) {
                    SqueezeBox.initialize({});
                    SqueezeBox.assign(jfbcJQuery('a.modal_jform_attribs_user_id').get(), {
                        parse: 'rel'
                    });
                });
                jfbcMakePrettyRadioButtons();
            },
            checkForAccessField: function(value)
            {
                var provider = jfbcJQuery("#jform_provider").val();
                var type = jfbcJQuery("#jform_type").val();
                var plugins = jfbcJQuery("#jform_autopost_plugins").val();
                var objects = jfbcJQuery("#jform_autopost_objects").val();
                console.log("ShowAccessField");
                console.log(plugins);
                console.log(objects);
                jfbcAdmin.ajax('option=com_jfbconnect&controller=ajax&task=showAccessField&provider=' + provider + '&type=' + type + (objects ? '&objects=' + objects:'') + (plugins ?'&plugins=' + plugins: ''), jfbcAdmin.channels.outbound.showAccessField);
            },
            showAccessField: function(ret)
            {
                if (!jfbcJQuery('#jform_autopost_access_type-lbl').length)
                    jfbcJQuery(ret).appendTo("#channel-attribs");
                else
                    jfbcJQuery('#jform_autopost_access_type-lbl').parent().html(ret);
            },
            showSetupMessage: function (ret)
            {
                jfbcJQuery('#channel-attribs').html('<div class="jfbc-error">' + jfbc_language_click_save + '</div>');
            },
            onuserchange: function (ret)
            {
                var userid = jfbcJQuery("#jform_attribs_user_id_id").val();
                var provider = jfbcJQuery("#jform_provider").val();
                var type = jfbcJQuery("#jform_type").val();
                jfbcAdmin.ajax('option=com_jfbconnect&controller=ajax&task=channelUpdateUser&provider='+provider+'&type='+type+'&userid='+userid, jfbcAdmin.channels.outbound.showAttribs);
            }
        }
    },
    checkForUpdate: function ()
    {
        /**
         * @copyright    Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
         * @license        GNU General Public License version 2 or later; see LICENSE.txt
         */
        jfbcJQuery(document).ready(function ()
        {
            var ajax_structure = {
                success: function (data, textStatus, jqXHR)
                {
                    try
                    {
                        var updateInfoList = jfbcJQuery.parseJSON(data);
                    } catch (e)
                    {
                        // An error occured
                        jfbcJQuery('#jfbconnect_update_icon').find('span').html(jfbconnect_update_text.ERROR);
                    }
                    if (updateInfoList instanceof Array)
                    {
                        if (updateInfoList.length < 1)
                        {
                            // No updates
                            jfbcJQuery('#jfbconnect_update_icon').find('span').html(jfbconnect_update_text.UPTODATE);
                        } else
                        {
                            jfbcJQuery('#jfbconnect_update_icon').find('span').html(jfbconnect_update_text.UPTODATE);
                            jfbcJQuery.each(updateInfoList, function (k, v)
                            {
                                if (v.extension_id == jfbconnect_extension_id)
                                    jfbcJQuery('#jfbconnect_update_icon').find('span').html(jfbconnect_update_text.UPDATEFOUND);
                            });
                        }
                    } else
                    {
                        // An error occured
                        jfbcJQuery('#jfbconnect_update_icon').find('span').html(jfbconnect_update_text.ERROR);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    // An error occured
                    jfbcJQuery('#jfbconnect_update_icon').find('span').html(jfbconnect_update_text.ERROR);
                },
                url: jfbconnect_update_ajax_url + '&eid=0&skip=700'
            };
            ajax_object = new jfbcJQuery.ajax(ajax_structure);
        });
    }
}