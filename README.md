# simplesm2
该项目是在 https://github.com/lpilp/phpsm2sm3sm4 的基础上做了简化， 只保留使用php-gmp组件，使用yum直接安装就可，asn1针对本项目进行了降级处理，只使用了\0x30, \0x02,\0x04三种类型，且只解析一层； ecc中只用到了point类 都已独立
## 要求
  * php >=5.6  64位版本
  * 打开gmp组件 检测方法  php -m | grep gmp 


## Stargazers over time
[![Stargazers over time](https://starchart.cc/oljc/arco-admin.svg?variant=adaptive)](https://starchart.cc/oljc/arco-admin)
