# -*- coding: utf-8 -*-
"""Enseignes Motors Studio / Motor Consulting — 2500 x 1250 mm, 4 px/mm (10000 x 5000 px)."""
from PIL import Image, ImageDraw, ImageFont, ImageFilter, ImageChops
import numpy as np, os, sys, math
S='/tmp/claude-0/-home-user-dossier/898ec426-d765-507b-abaa-ff7991e6fa5f/scratchpad'
FONTS='/root/.claude/skills/synced/01dd2791-5b44-42d0-b06e-5613d08e34f8_5bb9d59d-1ec1-423e-b1db-f4f0879c40da/canvas-design/canvas-fonts'
OUT='/home/user/dossier/docs/enseignes/print'
PX=4  # px par mm
W,H=2500*PX,1250*PX
rng=np.random.default_rng(7)

def mm(v): return int(round(v*PX))

# ------------------------------------------------------------------ logos
def logo_rgba(path, light_letters, text_start=0.66):
    """Logo sur fond noir -> RGBA. light_letters : inverse la luminosité des lettres grises (pour fond sombre)."""
    a=np.array(Image.open(path).convert('RGB')).astype(np.float32)/255.0
    mx=a.max(axis=2); mn=a.min(axis=2)
    alpha=np.clip((mx-0.015)/0.14,0,1)
    # le logo a été aplati sur noir : on retrouve la vraie couleur des bords (dé-prémultiplication) pour éviter les franges sombres
    safe=np.maximum(alpha,1e-3)[:,:,None]
    a=np.where(alpha[:,:,None]>0.02, np.clip(a/safe,0,1), a)
    # lissage léger du bord
    from PIL import ImageFilter as _F
    alpha=np.array(Image.fromarray((alpha*255).astype(np.uint8)).filter(_F.GaussianBlur(0.6))).astype(np.float32)/255.0
    # trous dans les lettres : les pixels noirs entourés (lettres sombres) restent transparents -> on garde, c'est le fond
    if light_letters:
        l=(mx+mn)/2; d=mx-mn
        s=np.where(d<1e-6,0,d/(1-np.abs(2*l-1)+1e-6))
        H_,W_=mx.shape
        mask=(alpha>0.05)&(s<0.30)
        mask[:int(H_*text_start),:]=False
        new=a.copy()
        inv=1-l
        for c in range(3):
            new[:,:,c]=np.where(mask,np.clip(inv*0.9+0.1,0,1),a[:,:,c])
        a=new
    rgba=np.dstack([(a*255).astype(np.uint8),(alpha*255).astype(np.uint8)])
    return Image.fromarray(rgba,'RGBA')

# ------------------------------------------------------------------ fond
def fond(dark, accent):
    base=(12,13,17) if dark else (242,243,245)
    img=Image.new('RGB',(W,H),base)
    # brossé horizontal : bruit 1D étiré
    noise=rng.normal(0,1,(H//8,1)).astype(np.float32)
    noise=np.repeat(np.repeat(noise,8,axis=0),W,axis=1)[:H,:W]
    noise2=rng.normal(0,1,(H,W//40)).astype(np.float32); noise2=np.repeat(noise2,40,axis=1)[:,:W]
    tex=(noise*0.6+noise2*0.4)
    amp=5 if dark else 4
    arr=np.array(img).astype(np.float32)+tex[:,:,None]*amp
    # vignette
    yy,xx=np.mgrid[0:H,0:W]
    r=np.sqrt(((xx-W*0.42)/(W*0.62))**2+((yy-H*0.5)/(H*0.75))**2)
    vig=np.clip(1-0.32*np.clip(r-0.55,0,1)**1.3,0,1) if dark else np.clip(1-0.06*np.clip(r-0.6,0,1),0,1)
    arr=arr*vig[:,:,None]
    # lueur de marque derrière l'emblème
    if dark:
        gx,gy=W*0.30,H*0.47
        g=np.exp(-(((xx-gx)/(W*0.22))**2+((yy-gy)/(H*0.42))**2))
        col=np.array(accent,dtype=np.float32)
        arr=arr+g[:,:,None]*col[None,None,:]*0.16
    return Image.fromarray(np.clip(arr,0,255).astype(np.uint8),'RGB')

def band(img, accent, dark):
    """Filet d'accent en haut, pleine largeur, dégradé lumineux au centre."""
    d=ImageDraw.Draw(img)
    h=mm(14)
    grad=np.linspace(0,1,W)
    lum=0.55+0.45*np.exp(-((grad-0.5)/0.35)**2)
    a=np.array(accent,dtype=np.float32)
    row=(a[None,:]*lum[:,None]).astype(np.uint8)
    strip=np.repeat(row[None,:,:],h,axis=0)
    img.paste(Image.fromarray(strip,'RGB'),(0,0))
    # fin liseré argent sous la bande
    d.line([(0,h),(W,h)],fill=(190,194,200) if dark else (120,124,130),width=mm(1.2))

def text_tracked(d, xy, txt, font, fill, tracking):
    x,y=xy
    for ch in txt:
        d.text((x,y),ch,font=font,fill=fill)
        x+=font.getlength(ch)+tracking
    return x-tracking

def width_tracked(txt,font,tracking):
    return sum(font.getlength(c) for c in txt)+tracking*(len(txt)-1)

# ------------------------------------------------------------------ enseigne
def enseigne(nom, logo_path, accent, lignes, tel, site, dark=True, slug=''):
    img=fond(dark,accent)
    band(img,accent,dark)
    # emblème
    logo=logo_rgba(logo_path, light_letters=dark)
    lh=mm(820); lw=int(lh*logo.width/logo.height)
    logo=logo.resize((lw,lh),Image.LANCZOS)
    lx,ly=mm(95), (H-lh)//2+mm(8)
    if dark:
        # ombre portée douce
        sh=Image.new('RGBA',(lw+mm(80),lh+mm(80)),(0,0,0,0))
        sh.paste(Image.new('RGBA',(lw,lh),(0,0,0,170)),(mm(40),mm(40)),logo)
        sh=sh.filter(ImageFilter.GaussianBlur(mm(14)))
        img.paste(sh,(lx-mm(40)+mm(6),ly-mm(40)+mm(14)),sh)
    img.paste(logo,(lx,ly),logo)

    d=ImageDraw.Draw(img)
    ink=(236,238,242) if dark else (22,25,31)
    ink2=(150,156,166) if dark else (95,100,110)
    line=(70,74,82) if dark else (200,204,210)
    # séparateur vertical
    sx=mm(1640)
    d.line([(sx,mm(300)),(sx,mm(950))],fill=line,width=mm(1.5))
    # colonne droite
    cx=mm(1745)
    f_act=ImageFont.truetype(os.path.join(FONTS,'Outfit-Regular.ttf'),mm(76))
    f_tel=ImageFont.truetype(os.path.join(FONTS,'Outfit-Bold.ttf'),mm(84))
    f_site=ImageFont.truetype(os.path.join(FONTS,'Outfit-Regular.ttf'),mm(52))
    tr=mm(7)
    y=mm(312)
    step=mm(86)
    for i,l in enumerate(lignes):
        # puce
        r=mm(5)
        cy=y+mm(38)
        d.ellipse([cx-mm(34)-r,cy-r,cx-mm(34)+r,cy+r],fill=accent)
        text_tracked(d,(cx,y),l,f_act,ink,tr)
        y+=step
    y+=mm(18)
    d.line([(cx,y),(cx+mm(600),y)],fill=line,width=mm(1.5))
    y+=mm(42)
    text_tracked(d,(cx,y),tel,f_tel,ink,mm(3))
    y+=mm(104)
    text_tracked(d,(cx,y),site,f_site,ink2,mm(2))
    # repère discret bas-gauche
    f_small=ImageFont.truetype(os.path.join(FONTS,'Outfit-Regular.ttf'),mm(22))
    text_tracked(d,(mm(110),H-mm(78)),'MAINVILLIERS · CHARTRES',f_small,ink2,mm(4))
    return img

def save(img, name):
    p=os.path.join(OUT,name+'.png'); img.save(p,optimize=False,compress_level=6)
    prev=img.resize((2000,1000),Image.LANCZOS); prev.save(os.path.join(S,name+'-apercu.jpg'),quality=88)
    print(name, img.size, os.path.getsize(p)//1024,'Ko')

studio=dict(nom='Motors Studio', logo_path=S+'/catalogue/p6_img1.png', accent=(227,35,26),
            lignes=['CARROSSERIE','PEINTURE','MÉCANIQUE','PNEUS','PARE-BRISE'], tel='09 55 32 08 89', site='www.motors-studio.fr')
consulting=dict(nom='Motor Consulting', logo_path=S+'/logopdf/p1_img0.png', accent=(10,120,230),
            lignes=['ACHAT','VENTE','DÉPÔT-VENTE','EXPERTISE','LOCATION'], tel='09 55 32 08 89', site='motorconsulting.fr')
which=sys.argv[1] if len(sys.argv)>1 else 'all'
jobs=[]
if which in ('all','studio'): jobs+= [('enseigne-motors-studio-2500x1250-sombre',studio,True),('enseigne-motors-studio-2500x1250-claire',studio,False)]
if which in ('all','consulting'): jobs+= [('enseigne-motor-consulting-2500x1250-sombre',consulting,True),('enseigne-motor-consulting-2500x1250-claire',consulting,False)]
for name,cfg,dark in jobs:
    save(enseigne(dark=dark,**cfg),name)
