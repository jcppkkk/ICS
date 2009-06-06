"set langmenu=zh_TW.Big5
""Sets how many lines of history VIM har to remember
set history=200
set ruler		" show the cursor position all the time
set showcmd		" display incomplete commands
set incsearch	" do incremental searching
set number
set ffs=unix ff=unix
set nocompatible
set backspace=indent,eol,start
set formatoptions=mroqBM
set laststatus=2	"Display a status-bar.
set showmatch	"Show matching parenthese.
set textwidth=700
let mapleader="\,"
set nowrap
set stal=2
"set tty=linux
"set term=xterm
"set ttym=xterm2
set tf
set title
set nomore
set bg=dark
" tabs and indenting
set tabstop=8
set shiftwidth=4
set softtabstop=4
set expandtab
set smarttab
set shiftround
set smartindent
"set mouse=i


nmap <silent> <leader>lv :lv /<c-r>=expand("<cword>")<cr>/ %<cr>:lw<cr>

"Tagkist setting
let Tlist_Show_One_File = 0 " Displaying tags for only one file~
let Tlist_Exist_OnlyWindow = 1 " if you are the last, kill yourself
let Tlist_Use_Right_Window = 0 " split to the right side of the screen
let Tlist_Sort_Type = "order" " sort by order or name
let Tlist_Display_Prototype = 0 " do not show prototypes and not tags in the taglist window.
let Tlist_Compart_Format = 1 " Remove extra information and blank lines from the taglist window.
let Tlist_GainFocus_On_ToggleOpen = 0 " Jump to taglist window on open.
let Tlist_Display_Tag_Scope = 1 " Show tag scope next to the tag name.
let Tlist_Close_On_Select = 0 " Close the taglist window when a file or tag is selected.
let Tlist_Enable_Fold_Column = 0 " Don't Show the fold indicator column in the taglist window.
let Tlist_WinWidth = 40

if has("vms")
	set nobackup	" do not keep a backup file, use versions instead
else
	set backup		" keep a backup file
endif

map Q gq

   "map! <Esc>Ol <kPlus>
   "map <Esc>Ol <kPlus>
   "map! <Esc>Op <k0>
   "map <Esc>Op <k0>
   "map! <Esc>Oq <k1>
   "map <Esc>Oq <k1>
   "map! <Esc>Or <k2>
   "map <Esc>Or <k2>
   "map! <Esc>Os <k3>
   "map <Esc>Os <k3>
   "map! <Esc>Ot <k4>
   "map <Esc>Ot <k4>
   "map! <Esc>Ou <k5>
   "map <Esc>Ou <k5>
   "map! <Esc>Ov <k6>
   "map <Esc>Ov <k6>
   "map! <Esc>Ow <k7>
   "map <Esc>Ow <k7>
   "map! <Esc>Ox <k8>
   "map <Esc>Ox <k8>
   "map! <Esc>Oy <k9>
   "map <Esc>Oy <k9>

map! <ESC>OP <F1>
map <ESC>OP <F1>
map! <ESC>OQ <F2>
map <ESC>OQ <F2>
map! <ESC>OR <F3>
map <ESC>OR <F3>
map! <ESC>OS <F4>
map <ESC>OS <F4>
map! <ESC>[15~ <F5>
map <ESC>[15~ <F5>
map! <ESC>[17~ <F6>
map <ESC>[17~ <F6>
map! <ESC>[18~ <F7>
map <ESC>[18~ <F7>
map! <ESC>[19~ <F8>
map <ESC>[19~ <F8>
map! <ESC>[20~ <F9>
map <ESC>[20~ <F9>
map! <ESC>[21~ <F10>
map <ESC>[21~ <F10>
map! <ESC>[23~ <F11>
map <ESC>[23~ <F11>
map! <ESC>[24~ <F12>
map <ESC>[24~ <F12>

map OH <home>
map OF <end>
map! OH <home>
map! OF <end>
imap <Home> <Esc>^i
nmap <Home> ^

map ZZ :wqa<CR>
""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""
" box comments tool
"""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""
vmap <silent>c<right>   !boxes -t 4 -d c-cmt2 <CR>
vmap <silent>c<left>    !boxes -t 4 -d c-cmt2 -r<CR>
vmap <silent>c<up>      !boxes -t 4 <CR>
vmap <silent>c<down>    !boxes -t 4 -r<CR>

"""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""
" <F2~4> grep
"""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""
"nnoremap <silent> <F2> :cprev<CR>
"nnoremap <silent> <F3> :GrepBuffer<CR><CR>
"nnoremap <silent> <F4> :cnext<CR>
map <F2> :set expandtab!<BAR>set expandtab?<CR>
"""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""
" <F5> update file
"""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""
map <F5> :up<CR>
"map <F5> :call Mosh_html2text()<cr>
function! Mosh_html2text()
    silent! %s/&lt;/</g
    silent! %s/&gt;/>/g
    silent! %s/&amp;/&/g
    silent! %s/&quot;/"/g
    silent! %s/&nbsp;/ /g
    silent! %s/&ntilde;/\~/g
    silent! %s/<P>//g
    silent! %s/<BR>/^M/g
    silent! %s/</\?[BI]>/ /g
    set readonly
endfun
"""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""
" <F6> replace string
"""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""
map <F6> :%s/\<<c-r>=expand("<cword>")<cr>\>//g<left><left><left>
 map <F6> :bn<CR>    " ¤U¤@­Ó buffer ÀÉ®×
"""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""
" <F7> ±±¨î syntax on/off¡C­Ë±×½u¬O Vim script ªº§é¦æ¼Ð»x
"""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""
map <F7> :if exists("syntax_on") <BAR>
            \   syntax off <BAR><CR>
            \ else <BAR>
            \   syntax enable <BAR>
            \ endif <CR>
"map <F7> :call MipsFormat()<cr>gg
function! MipsFormat()
    silent! %s/ //g
    silent! %s/:\(.\{6\}\)\(.\{5\}\)\(.\{5\}\)\(.\{5\}\)\(.\{5\}\)\(.\{6\}\)/:\1_\2_\3_\4_\5_\6;/g
    silent! %s/:001000/ addi  &/g
    silent! %s/:001001/ addiu &/g
    silent! %s/:001100/ andi  &/g
    silent! %s/:000100/ beq   &/g
    silent! %s/:000001/ bgez  &/g
    silent! %s/:000111/ bgtz  &/g
    silent! %s/:000110/ blez  &/g
    silent! %s/:000001/ bltz  &/g
    silent! %s/:000101/ bne   &/g
    silent! %s/:100000/ lb    &/g
    silent! %s/:100100/ lbu   &/g
    silent! %s/:100001/ lh    &/g
    silent! %s/:100101/ lhu   &/g
    silent! %s/:001111/ lui   &/g
    silent! %s/:100011/ lw    &/g
    silent! %s/:110001/ lwc1  &/g
    silent! %s/:001101/ ori   &/g
    silent! %s/:101000/ sb    &/g
    silent! %s/:001010/ slti  &/g
    silent! %s/:001011/ sltiu &/g
    silent! %s/:101001/ sh    &/g
    silent! %s/:101011/ sw    &/g
    silent! %s/:111001/ swc1  &/g
    silent! %s/:001110/ xori  &/g
    silent! %s/:000010/ <--J  &/g
    silent! %s/:\(000000_00000_00000_00000_00000_000000\)/ -----  \1/g
    silent! %s/:000000.........................100000/ add   &/g
    silent! %s/:000000.........................100001/ addu  &/g
    silent! %s/:000000.........................100100/ and   &/g
    silent! %s/:000000.........................001101/ break &/g
    silent! %s/:000000.........................011010/ div   &/g
    silent! %s/:000000.........................011011/ divu  &/g
    silent! %s/:000000.........................001001/ jalr  &/g
    silent! %s/:000000.........................001000/ jr    &/g
    silent! %s/:000000.........................010000/ mfhi  &/g
    silent! %s/:000000.........................010010/ mflo  &/g
    silent! %s/:000000.........................010001/ mthi  &/g
    silent! %s/:000000.........................010011/ mtlo  &/g
    silent! %s/:000000.........................011000/ mult  &/g
    silent! %s/:000000.........................011001/ multu &/g
    silent! %s/:000000.........................100111/ nor   &/g
    silent! %s/:000000.........................100101/ or    &/g
    silent! %s/:000000.........................000000/ sll   &/g
    silent! %s/:000000.........................000100/ sllv  &/g
    silent! %s/:000000.........................101010/ slt   &/g
    silent! %s/:000000.........................101011/ sltu  &/g
    silent! %s/:000000.........................000011/ sra   &/g
    silent! %s/:000000.........................000111/ srav  &/g
    silent! %s/:000000.........................000010/ srl   &/g
    silent! %s/:000000.........................000110/ srlv  &/g
    silent! %s/:000000.........................100010/ sub   &/g
    silent! %s/:000000.........................100011/ subu  &/g
    silent! %s/:000000.........................001100/syscall&/g
    silent! %s/:000000.........................100110/ xor   &/g
    silent! %s/-  /- :/g
    silent! %s/\(\d\):/\1 ????? :/g
    "020 ????? :000000_00000_00000_00000_00000_000001;
    silent! %s/\d*\(.\{6,6}\)..\(.*\)/instruction_file[00]=32'b\2 \/\/\1/g
endfun
"""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""
" <F8> ·|¦b searching highlight ¤Î«D highlight ¶¡¤Á´«
"""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""
map <F8> :set hls!<BAR>set hls?<CR>
"""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""
" <F9> Toggle on/off paste mode
"""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""
map <F9> :set paste!<BAr>set paste?<CR>
set pastetoggle=<F9>

"""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""
" <B> <C> this script use to excute make in vim and open quickfix window
"""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""
nmap <silent> B :call Do_make2()<cr><cr><cr>
nmap <silent> C :cclose<cr>
function Do_make2()
    up
    execute "make"
    execute "copen"
endfunction
function Do_make()
    up
    let filename = bufname("%")
    let suffix_pos = strridx(filename, ".c")
    if suffix_pos == -1
        return
    else
        let target = strpart(filename,0,suffix_pos)
    endif
    let target = "make " . target
    execute target
    execute "copen"
endfunction

map <F10> :/* Last modified: /s@: \d\d\d\d-\d\d-\d\d \d\d:\d\d@\=strftime(": %Y-%m-%d %H:%M")@<CR>
"""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""
" autocmd setting
"""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""
if has("autocmd")
    filetype plugin indent on
    au!
    silent! %s/&lt;/</g
    autocmd BufReadPost * if line("'\"") > 0|if line("'\"") <= line("$")|exe("norm '\"")|else|exe "norm $"|endif|endif
        "autocmd FileType text setlocal textwidth=700
        autocmd BufWrite,FileWritePre * :%s/\s\+$//ge
        autocmd BufEnter *.sablecc set syntax=sablecc
        au Syntax sablecc so $HOME/.vim/syntax/sablecc.vim
        "autocmd BufWrite,FileWritePre *.c,*.cpp,*.h,*.v :/* Last modified: /s@:.*$@\=strftime(": %Y-%m-%d %H:%M")@
        autocmd BufNewFile *.c,*.cpp,*.h,*.v :call AddTitle()
        function AddTitle()
            r ~/homework/tool/sample.txt
            normal ggdd
            :/* Last modified: /s@:.*$@\=strftime(": %Y-%m-%d %H:%M")@
        endf
    else
        set autoindent	" always set autoindenting on
    endif


    "color
    if &t_Co > 2 || has("gui_running")
        syntax on
        set hlsearch
        "set t_Co=256
    endif
