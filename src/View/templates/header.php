<!DOCTYPE html>
<html>
    <head>
        {{head}}
    </head>
    <body {{body}}>
        <?php if ($this->getVar('backend', false) === true) : ?>
            <nav class="navbar navbar-default navbar-fixed-top navbar-inverse">
                <div class="container-fluid">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="{{base_url}}">
                            <img alt="Brand" src="{{logo}}" height="20">
                        </a>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        {{backend_menu}}
                        <div class="pull-right">{{backend_menu_user}}</div>
                    </div>
                </div>
            </nav>
        <?php endif; ?>
