from rest_framework import routers,serializers,viewsets
from .models import Status

class StatusSerializer(serializers.HyperlinkedModelSerializer):
    class Meta:
        model = Status
        fields = ['id', 'nama']