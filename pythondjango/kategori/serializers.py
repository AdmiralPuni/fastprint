from rest_framework import routers,serializers,viewsets
from .models import Kategori

class KategoriSerializer(serializers.HyperlinkedModelSerializer):
    class Meta:
        model = Kategori
        fields = ['id', 'nama']