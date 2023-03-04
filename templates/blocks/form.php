<?php
    $method    = $method    ?? 'POST';
    $action    = $action    ?? $_SERVER['REQUEST_URI'];
    $enctype   = $enctype   ?? 'application/x-www-form-urlencoded';
    $class     = $class     ?? 'row g-3';
    $btn_label = $btn_label ?? 'Enviar';
    $btn_class = $btn_class ?? 'btn btn-primary';
?>

<form class="<?= $class ?>" method="<?= $method ?>" action="<?= $action ?>" enctype="<?= $enctype ?>">
<?php
    foreach ($fields??[] as $f) {
        if (empty($f['name'])) {
            continue;
        }

        $f['class']        = $f['class'] ?? 'col-12';
        $f['placeholder']  = $f['placeholder'] ?? '';
        $f['label']        = $f['label'] ?? ucfirst($f['name']);
        $f['required']     = empty($f['required']) ? '' : 'required';
        $f['txt_required'] = empty($f['required']) ? '' : '<sup class="text-danger">*</sub>';
        $postValue         = $_POST[$f['name']] ?? '';

        switch ($f['type']) {
            case 'text':
            case 'email':
            case 'password':
                echo <<<HTML
                        <div class="{$f['class']}">
                            <label for="{$f['name']}" class="form-label">{$f['label']}{$f['txt_required']}</label>
                            <input type="{$f['type']}" class="form-control" id="{$f['name']}" name="{$f['name']}" placeholder="{$f['placeholder']}" {$f['required']} value="{$postValue}">
                        </div>
                    HTML;
                break;
            case 'checkbox':
                $f['labelcheck'] = $f['labelcheck'] ?? 'Marcar';
                $f['value']      = $f['value'] ?? '1';
                $checked         = ($f['value'] == $postValue) ? 'checked' : ''; 
                echo <<<HTML
                        <div class="{$f['class']}">
                            <label class="form-label">{$f['label']}{$f['txt_required']}</label>
                            <div class="form-check form-control" style="padding-left:2.2rem">
                                <input class="form-check-input" type="checkbox" name="{$f['name']}" id="{$f['name']}" value="{$f['value']}" {$f['required']} {$checked}>
                                <label class="form-check-label" for="{$f['name']}">
                                    {$f['labelcheck']}
                                </label>
                            </div>
                        </div>
                    HTML;
                break;
            case 'select':
                $options = '';
                foreach($f['options'] as $o) {
                    $selected = ($o['value'] == $postValue) ? 'selected' : ''; 
                    $options .= sprintf('<option value="%s" %s>%s</option>', $o['value'], $selected, $o['label']);
                }
                echo <<<HTML
                        <div class="{$f['class']}">
                            <label for="{$f['name']}" class="form-label">{$f['label']}{$f['txt_required']}</label>
                            <select id="{$f['name']}" name="{$f['name']}" class="form-select" {$f['required']}>
                                <option value="">Selecione...</option>
                                {$options}
                            </select>
                        </div>
                        HTML;
                break;
            case 'radio-inline':
                $html = '';
                $qtd = 1;
                foreach($f['options'] as $o) {
                    $checked = ($o['value'] == $postValue) ? 'checked' : ''; 
                    $html .= <<<HTML
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="{$f['name']}" id="{$f['name']}{$qtd}" value="{$o['value']}" {$f['required']} {$checked}>
                            <label class="form-check-label" for="{$f['name']}{$qtd}">{$o['label']}</label>
                        </div>
                    HTML;
                    $qtd++;
                }
                echo <<<HTML
                        <div class="{$f['class']}">
                            <label class="form-label">{$f['label']}{$f['txt_required']}</label>
                            <div class="form-control">
                                {$html}    
                            </div>
                        </div>
                        HTML;
                break;
            case 'textarea':
                $rows = $f['rows'] ?? '';
                $cols = $f['cols'] ?? '';
                echo <<<HTML
                        <div class="{$f['class']}">
                            <label for="{$f['name']}" class="form-label">{$f['label']}{$f['txt_required']}</label>
                            <textarea class="form-control" id="{$f['name']}" name="{$f['name']}" placeholder="{$f['placeholder']}" rows="{$rows}" cols="{$cols}" {$f['required']}>{$postValue}</textarea>
                        </div>
                    HTML;
                break;
            case 'readonly':
                echo <<<HTML
                    <div class="{$f['class']}">
                        <label class="form-label">{$f['label']}{$f['txt_required']}</label>
                        <input type="text" class="form-control-plaintext border-bottom bg-light ps-1" value="{$postValue}" readonly>
                    </div>
                HTML;
                break;
            case 'file':
                $f['accept'] = empty($f['accept']) ? '' : "accept='{$f['accept']}'";
                echo <<<HTML
                        <div class="{$f['class']}">
                            <label for="{$f['name']}" class="form-label">{$f['label']}{$f['txt_required']}</label>
                            <input type="{$f['type']}" class="form-control" id="{$f['name']}" name="{$f['name']}" {$f['required']} {$f['accept']}>
                        </div>
                    HTML;
                break;
        }
    }
?>

    <div class="col-12 text-center">
        <button type="submit" class="<?= $btn_class ?>"><?= $btn_label ?></button>
    </div>
</form>