<?php
declare(strict_types=1);

namespace Phan;

class Deprecated {

    public static function bc_check($file, $ast) {
        if($ast->children[0] instanceof \ast\Node) {
            if($ast->children[0]->kind == \ast\AST_DIM) {
                $temp = $ast->children[0]->children[0];
                $last = $temp;
                if($temp->kind == \ast\AST_PROP || $temp->kind == \ast\AST_STATIC_PROP) {
                    while($temp instanceof \ast\Node && ($temp->kind == \ast\AST_PROP || $temp->kind == \ast\AST_STATIC_PROP)) {
                        $last = $temp;
                        $temp = $temp->children[0];
                    }
                    if($temp instanceof \ast\Node) {
                        if(($last->children[1] instanceof \ast\Node && $last->children[1]->kind == \ast\AST_VAR) && ($temp->kind == \ast\AST_VAR || $temp->kind == \ast\AST_NAME)) {
                            $ftemp = new \SplFileObject($file);
                            $ftemp->seek($ast->lineno-1);
                            $line = $ftemp->current();
                            unset($ftemp);
                            if(strpos($line,'}[') === false || strpos($line,']}') === false || strpos($line,'>{') === false) {
                                Log::err(Log::ECOMPAT, "expression may not be PHP 7 compatible", $file, $ast->lineno);
                            }
                        }
                    }
                }
            }
        }
    }

}
